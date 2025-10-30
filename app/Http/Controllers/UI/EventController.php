<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $searchTerm = $request->get('search');

        $data['events'] = Event::with(['venue'])
            ->search($searchTerm)
            ->orderBy('event_date')
            ->get();

        $data['searchTerm'] = $searchTerm;

        return view('events.index', $data);
    }

    public function show(int $eventId): View
    {
        $data['event'] = Event::with(['venue', 'ticketCategories'])->findOrFail($eventId);

        return view('events.show', $data);
    }
}
