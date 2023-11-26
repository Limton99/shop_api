<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items= [
            [
                'name' => 'Соки',
                'slug' => Str::slug('Соки')
            ],
            [
                'name' => 'Мясо',
                'slug' => Str::slug('Мясо')
            ],
        ];

        foreach ($items as $item) {
            Category::create($item);
        }
    }
}
