<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\TicketCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventTicketCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = Event::all();
        $categories = TicketCategory::all()->keyBy('name');

        foreach ($events as $event) {
            $title = strtolower($event->title);

            if (str_contains($title, 'konser') || str_contains($title, 'aksu') || str_contains($title, 'teoman') || str_contains($title, 'tarkan')) {
                $event->ticketCategories()->attach([
                    $categories['Genel Giriş']->id => ['price' => 250.00],
                    $categories['VIP']->id => ['price' => 450.00],
                    $categories['Balkon']->id => ['price' => 200.00],
                    $categories['Öğrenci']->id => ['price' => 150.00],
                ]);
            } elseif (str_contains($title, 'stand-up') || str_contains($title, 'cem yılmaz')) {
                $event->ticketCategories()->attach([
                    $categories['Genel Giriş']->id => ['price' => 350.00],
                    $categories['VIP']->id => ['price' => 550.00],
                    $categories['Öğrenci']->id => ['price' => 200.00],
                    $categories['Balkon']->id => ['price' => 250.00],
                ]);
            } elseif (str_contains($title, 'tiyatro') || str_contains($title, 'hamlet') || str_contains($title, 'bale') || str_contains($title, 'senfoni') || str_contains($title, 'orkestra')) {
                $event->ticketCategories()->attach([
                    $categories['Genel Giriş']->id => ['price' => 200.00],
                    $categories['VIP']->id => ['price' => 400.00],
                    $categories['Balkon']->id => ['price' => 150.00],
                    $categories['Öğrenci']->id => ['price' => 100.00],
                ]);
            } elseif (str_contains($title, 'film') || str_contains($title, 'sinema') || str_contains($title, 'dune') || str_contains($title, 'oppenheimer') || str_contains($title, 'yeşilçam')) {
                $event->ticketCategories()->attach([
                    $categories['Genel Giriş']->id => ['price' => 80.00],
                    $categories['VIP']->id => ['price' => 150.00],
                    $categories['Öğrenci']->id => ['price' => 50.00],
                    $categories['Balkon']->id => ['price' => 60.00],
                ]);
            } else {
                $event->ticketCategories()->attach([
                    $categories['Genel Giriş']->id => ['price' => 200.00],
                    $categories['VIP']->id => ['price' => 400.00],
                    $categories['Öğrenci']->id => ['price' => 120.00],
                    $categories['Balkon']->id => ['price' => 180.00],
                ]);
            }
        }
    }
}
