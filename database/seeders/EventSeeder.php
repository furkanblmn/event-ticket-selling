<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Venue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $venues = Venue::all();

        $events = [
            [
                'venue_id' => $venues->random()->id,
                'title' => 'Sezen Aksu Konseri',
                'description' => 'Türk Pop Müziğinin kraliçesi Sezen Aksu, unutulmaz bir konser ile sizlerle!',
                'image_url' => 'https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?w=800',
                'event_date' => now()->addDays(15)->setTime(20, 0),
            ],
            [
                'venue_id' => $venues->random()->id,
                'title' => 'Cem Yılmaz Stand-Up',
                'description' => 'Cem Yılmaz\'ın yeni gösterisi ile kahkaha dolu bir gece!',
                'image_url' => 'https://images.unsplash.com/photo-1585699324551-f6c309eedeca?w=800',
                'event_date' => now()->addDays(20)->setTime(21, 0),
            ],
            [
                'venue_id' => $venues->random()->id,
                'title' => 'Teoman Akustik Konser',
                'description' => 'Teoman\'dan unutulmaz bir akustik konser deneyimi.',
                'image_url' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800',
                'event_date' => now()->addDays(25)->setTime(20, 30),
            ],
            [
                'venue_id' => $venues->random()->id,
                'title' => 'Galatasaray vs Fenerbahçe',
                'description' => 'Sezonun en heyecanlı derbisi! Kaçırma!',
                'image_url' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=800',
                'event_date' => now()->addDays(30)->setTime(19, 0),
            ],
            [
                'venue_id' => $venues->random()->id,
                'title' => 'Tarkan Konseri',
                'description' => 'Mega Star Tarkan, en sevilen şarkılarıyla sahnede!',
                'image_url' => 'https://images.unsplash.com/photo-1514320291840-2e0a9bf2a9ae?w=800',
                'event_date' => now()->addDays(35)->setTime(21, 0),
            ],
            [
                'venue_id' => $venues->random()->id,
                'title' => 'Devlet Tiyatroları - Hamlet',
                'description' => 'Shakespeare\'in ölümsüz eseri Hamlet, modern yorumuyla sizlerle.',
                'image_url' => 'https://images.unsplash.com/photo-1503095396549-807759245b35?w=800',
                'event_date' => now()->addDays(40)->setTime(20, 0),
            ],
            [
                'venue_id' => $venues->random()->id,
                'title' => 'Klasik Müzik Festivali',
                'description' => 'Dünya çapında solistlerle klasik müziğin büyüsüne kapılın.',
                'image_url' => 'https://images.unsplash.com/photo-1519683384663-34c6d29471b7?w=800',
                'event_date' => now()->addDays(45)->setTime(19, 30),
            ],
            [
                'venue_id' => $venues->random()->id,
                'title' => 'Bale Gösterisi - Kuğu Gölü',
                'description' => 'Çaykovski\'nin başyapıtı Kuğu Gölü, muhteşem koreografisi ile.',
                'image_url' => 'https://images.unsplash.com/photo-1518834107812-67b0b7c58434?w=800',
                'event_date' => now()->addDays(50)->setTime(20, 0),
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
