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
                'name' => 'Zorlu PSM',
                'address' => 'Levazım, Koru Sk. No:2, 34340 Beşiktaş/İstanbul',
            ],
            [
                'name' => 'Ülker Sports Arena',
                'address' => 'Huzur, Şht. Muhtar Cd. No:82, 34396 Sarıyer/İstanbul',
            ],
            [
                'name' => 'Volkswagen Arena',
                'address' => 'Türk Telekom Stadyumu, Ayazağa, 34485 Sarıyer/İstanbul',
            ],
            [
                'name' => 'Harbiye Cemil Topuzlu Açıkhava Tiyatrosu',
                'address' => 'Harbiye, Taşkışla Cd., 34367 Şişli/İstanbul',
            ],
        ];

        foreach ($venues as $venue) {
            Venue::create($venue);
        }
    }
}
