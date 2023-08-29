<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Genre::factory()
            ->count(4)
            ->sequence(
                ['name' => 'Рок'],
                ['name' => 'Классика'],
                ['name' => 'Металл'],
                ['name' => 'Попса']
            )
            ->create();
    }
}
