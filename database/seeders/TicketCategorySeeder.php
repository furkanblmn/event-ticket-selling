<?php

namespace Database\Seeders;

use App\Models\TicketCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Genel Giriş',
                'price' => 150.00,
            ],
            [
                'name' => 'Protokol',
                'price' => 500.00,
            ],
            [
                'name' => 'VIP',
                'price' => 350.00,
            ],
            [
                'name' => 'Öğrenci',
                'price' => 100.00,
            ],
            [
                'name' => 'Balkon',
                'price' => 200.00,
            ],
            [
                'name' => 'Kale Arkası',
                'price' => 120.00,
            ],
        ];

        foreach ($categories as $category) {
            TicketCategory::create($category);
        }
    }
}
