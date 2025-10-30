<?php

namespace Database\Seeders;

use App\Models\Seat;
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
        $venues = Venue::all();

        foreach ($venues as $venue) {
            $sections = ['A', 'B', 'C', 'D'];
            $rows = range(1, 10);
            $seats = range(1, 25);

            foreach ($sections as $section) {
                foreach ($rows as $row) {
                    foreach (array_slice($seats, 0, 10) as $seatNumber) {
                        Seat::create([
                            'venue_id' => $venue->id,
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
