<?php

namespace Database\Seeders;

use App\Models\Venue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $venues = [
            [
                'name' => 'İstanbul Kongre Merkezi',
                'address' => 'Harbiye, Darülbedayi Cd. No:8, 34367 Şişli/İstanbul',
            ],
            [
                'name' => 'Zorlu PSM Sahne',
                'address' => 'Levazım, Koru Sk. No:2, 34340 Beşiktaş/İstanbul',
            ],
            [
                'name' => 'CinemaMaximum Marmara Park',
                'address' => 'Beylikdüzü, Marmara Park AVM, 34520 Beylikdüzü/İstanbul',
            ],
            [
                'name' => 'Cemal Reşit Rey Konser Salonu',
                'address' => 'Harbiye, Darülbedayi Cd., 34367 Şişli/İstanbul',
            ],
            [
                'name' => 'Kadıköy Sineması',
                'address' => 'Caferağa, Bahariye Cd. No:32, 34710 Kadıköy/İstanbul',
            ],
        ];

        foreach ($venues as $venue) {
            Venue::create($venue);
        }
    }
}
