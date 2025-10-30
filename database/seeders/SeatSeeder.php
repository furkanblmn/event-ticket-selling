<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Seat;
use App\Models\TicketCategory;
use App\Models\Venue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $seatsPerCategory = Event::SEATS_PER_CATEGORY / 10;

        $venues = Venue::all();
        $categories = TicketCategory::all()->keyBy('name');

        $sectionCategoryMap = [
            'A' => $categories['VIP']->id,
            'B' => $categories['Genel Giriş']->id,
            'C' => $categories['Balkon']->id,
            'D' => $categories['Öğrenci']->id,
        ];

        foreach ($venues as $venue) {
            $sections = ['A', 'B', 'C', 'D'];
            $rows = range(1, $seatsPerCategory);
            $seats = range(1, 10);

            foreach ($sections as $section) {
                foreach ($rows as $row) {
                    foreach ($seats as $seatNumber) {
                        Seat::create([
                            'venue_id' => $venue->id,
                            'ticket_category_id' => $sectionCategoryMap[$section],
                            'seat_number' => sprintf('%s-%d-%d', $section, $row, $seatNumber),
                            'section' => $section,
                            'row' => (string) $row,
                        ]);
                    }
                }
            }
        }
    }
}
