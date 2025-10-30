<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Seat;
use App\Models\Ticket;
use Illuminate\Contracts\View\View;

class SeatPlanController extends Controller
{
    public function index(int $eventId, int $categoryId): View
    {
        $data['event'] = Event::with(['venue', 'ticketCategories'])->findOrFail($eventId);
        $data['category'] = $data['event']->ticketCategories()->where('ticket_categories.id', $categoryId)->firstOrFail();

        $data['seats'] = Seat::with('category')
            ->where('venue_id', $data['event']->venue_id)
            ->ordered()
            ->get();

        $data['selectedCategoryId'] = $categoryId;

        $data['bookedSeatIds'] = Ticket::where('event_id', $eventId)
            ->whereNotNull('seat_id')
            ->pluck('seat_id')
            ->toArray();

        return view('seat-plans.index', $data);
    }
}
