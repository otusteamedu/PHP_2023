<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Track;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Track::factory()
            ->count(10)
            ->create();
    }
}
