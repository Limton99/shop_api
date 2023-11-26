<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items= [
            [
                'name' => 'Dada',
                'description' => "",
                'category_id' => 1,
                'price' => 450
            ],
            [
                'name' => 'Мясо',
                'description' => "",
                'category_id' => 2,
                'price' => 1200
            ],
        ];

        foreach ($items as $item) {
            Product::create($item);
        }
    }
}
