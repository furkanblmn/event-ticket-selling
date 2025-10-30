<?php

namespace App\Services;

use App\Logging\AppLogger;
use App\Mail\OrderConfirmationMail;
use App\Models\Event;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Throwable;

class PaymentService
{
    public function processPayment(array $validated): Order
    {
        $ticketCount = !empty($validated['seats']) ? count($validated['seats']) : 1;

        AppLogger::info('Payment process started', [
            'channel' => 'payment',
            'event_id' => $validated['event_id'],
            'category_id' => $validated['ticket_category_id'],
            'ticket_count' => $ticketCount,
            'customer_email' => $validated['customer_email'],
            'seat_ids' => $validated['seats'] ?? null,
        ]);

        try {
            $order = DB::transaction(function () use ($validated, $ticketCount) {
                $this->checkStock($validated, $ticketCount);

                $order = $this->createOrder($validated);
                $totalAmount = $this->calculateTotal($validated);

                $this->createTickets($validated, $order->id, $ticketCount);
                $this->createPayment($validated, $order->id, $totalAmount);

                AppLogger::info('Order created', [
                    'channel' => 'payment',
                    'order_id' => $order->id,
                    'total_amount' => $totalAmount,
                    'ticket_count' => $ticketCount,
                ]);

                return $order;
            });

            $order->load(['tickets.event.venue', 'tickets.category', 'tickets.seat', 'payment']);
            $this->sendConfirmationEmail($order);

            AppLogger::info('Payment process completed', [
                'channel' => 'payment',
                'order_id' => $order->id,
                'customer_email' => $order->email,
                'total_amount' => $order->payment->total_amount,
            ]);

            return $order;
        } catch (Throwable $e) {
            AppLogger::error('Payment process failed', $e, [
                'channel' => 'payment',
                'event_id' => $validated['event_id'],
                'category_id' => $validated['ticket_category_id'],
                'customer_email' => $validated['customer_email'],
            ]);
            throw $e;
        }
    }

    private function checkStock(array $data, int $ticketCount): void
    {
        $event = Event::findOrFail($data['event_id']);
        $availableStock = $event->getAvailableStockForCategory($data['ticket_category_id']);

        AppLogger::info('Stock checked', [
            'channel' => 'payment',
            'event_id' => $data['event_id'],
            'category_id' => $data['ticket_category_id'],
            'requested_tickets' => $ticketCount,
            'available_stock' => $availableStock,
        ]);

        if ($availableStock < $ticketCount) {
            AppLogger::warning('Insufficient stock', [
                'channel' => 'payment',
                'event_id' => $data['event_id'],
                'category_id' => $data['ticket_category_id'],
                'requested' => $ticketCount,
                'available' => $availableStock,
            ]);
            throw new \Exception('Yetersiz stok! Sadece ' . $availableStock . ' adet bilet kaldı.');
        }

        if (!empty($data['seats'])) {
            $this->checkSeatAvailability($data['event_id'], $data['seats']);
        }
    }

    private function checkSeatAvailability(int $eventId, array $seatIds): void
    {
        $soldSeats = Ticket::where('event_id', $eventId)
            ->whereIn('seat_id', $seatIds)
            ->whereNull('deleted_at')
            ->pluck('seat_id')
            ->toArray();

        if (!empty($soldSeats)) {
            AppLogger::warning('Seat(s) already sold', [
                'channel' => 'payment',
                'event_id' => $eventId,
                'requested_seats' => $seatIds,
                'sold_seats' => $soldSeats,
            ]);

            throw new \Exception('Seçtiğiniz koltuklar daha önce satın alınmış. Lütfen başka koltuklar seçin.');
        }

        AppLogger::info('Seat availability verified', [
            'channel' => 'payment',
            'event_id' => $eventId,
            'seat_count' => count($seatIds),
        ]);
    }

    private function createOrder(array $data): Order
    {
        return Order::create([
            'name' => $data['customer_name'],
            'surname' => $data['customer_surname'],
            'email' => $data['customer_email'],
            'phone' => $data['customer_phone'],
        ]);
    }

    private function calculateTotal(array $data): float
    {
        $event = Event::findOrFail($data['event_id']);
        $category = $event->ticketCategories()
            ->where('ticket_categories.id', $data['ticket_category_id'])
            ->firstOrFail();

        $ticketCount = !empty($data['seats']) ? count($data['seats']) : 1;

        return $category->pivot->price * $ticketCount;
    }

    private function createTickets(array $data, int $orderId, int $ticketCount): void
    {
        $now = now();
        $baseTicketData = [
            'event_id' => $data['event_id'],
            'category_id' => $data['ticket_category_id'],
            'order_id' => $orderId,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        $tickets = !empty($data['seats'])
            ? array_map(fn($seatId) => array_merge($baseTicketData, ['seat_id' => $seatId]), $data['seats'])
            : [array_merge($baseTicketData, ['seat_id' => null])];

        Ticket::insert($tickets);
    }

    private function createPayment(array $data, int $orderId, float $totalAmount): void
    {
        Payment::create([
            'order_id' => $orderId,
            'total_amount' => $totalAmount,
            'cc_number' => substr($data['cc_number'], -4),
            'cc_exp_month' => $data['cc_exp_month'],
            'cc_exp_year' => $data['cc_exp_year'],
            'cc_cvv' => $data['cc_cvv'],
        ]);
    }

    private function sendConfirmationEmail(Order $order): void
    {
        try {
            Mail::to($order->email)->send(new OrderConfirmationMail($order));

            AppLogger::info('Confirmation email sent', [
                'channel' => 'payment',
                'order_id' => $order->id,
                'customer_email' => $order->email,
            ]);
        } catch (Throwable $e) {
            AppLogger::error('Failed to send confirmation email', $e, [
                'channel' => 'payment',
                'order_id' => $order->id,
                'customer_email' => $order->email,
            ]);
        }
    }
}
