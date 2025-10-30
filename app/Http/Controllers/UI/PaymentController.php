<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\CreateRequest;
use App\Http\Requests\Payment\StoreRequest;
use App\Logging\AppLogger;
use App\Models\Event;
use App\Models\Order;
use App\Models\Seat;
use App\Services\PaymentService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Payment Controller
 *
 * Handles payment form display, processing and success page
 * Uses centralized AppLogger for structured logging
 */
class PaymentController extends Controller
{
    public function __construct(private PaymentService $paymentService) {}

    public function create(CreateRequest $request): View
    {
        $validated = $request->validated();

        AppLogger::info('Payment page accessed', [
            'channel' => 'payment',
            'event_id' => $validated['event_id'],
            'category_id' => $validated['ticket_category_id'],
            'seat_count' => isset($validated['seats']) ? count($validated['seats']) : 1,
            'ip_address' => $request->ip(),
        ]);

        $event = Event::with(['venue', 'ticketCategories'])
            ->findOrFail($validated['event_id']);

        $category = $event->ticketCategories()
            ->where('ticket_categories.id', $validated['ticket_category_id'])
            ->firstOrFail();

        $seats = Seat::whereIn('id', $validated['seats'] ?? [])->get();
        $seatCount = max($seats->count(), 1);
        $totalAmount = $category->pivot->price * $seatCount;

        return view('payments.create', compact('event', 'category', 'seats', 'seatCount', 'totalAmount'));
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        AppLogger::info('Payment form submitted', [
            'channel' => 'payment',
            'event_id' => $validated['event_id'],
            'category_id' => $validated['ticket_category_id'],
            'customer_email' => $validated['customer_email'],
            'ip_address' => $request->ip(),
        ]);

        try {
            $order = $this->paymentService->processPayment($validated);

            AppLogger::info('Redirecting to success page', [
                'channel' => 'payment',
                'order_id' => $order->id,
                'customer_email' => $order->email,
            ]);

            return redirect()->route('payments.success', $order->id);
        } catch (Exception $e) {
            AppLogger::error('Payment controller error', $e, [
                'channel' => 'payment',
                'event_id' => $validated['event_id'],
                'category_id' => $validated['ticket_category_id'],
                'customer_email' => $validated['customer_email'],
                'ip_address' => $request->ip(),
            ]);

            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function success(int $orderId): View
    {
        $order = Order::with(['tickets.event', 'tickets.category', 'tickets.seat', 'payment'])
            ->findOrFail($orderId);

        AppLogger::info('Success page viewed', [
            'channel' => 'payment',
            'order_id' => $orderId,
            'customer_email' => $order->email,
            'total_amount' => $order->payment->total_amount,
        ]);

        return view('payments.success', compact('order'));
    }
}
