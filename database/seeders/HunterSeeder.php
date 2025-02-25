<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hunter;

class HunterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Hunter::create(['name' => 'Jinwoo', 'rank' => 'S', 'level' => 100]);
        Hunter::create(['name' => 'Baek Yoonho', 'rank' => 'A', 'level' => 85]);
    }
}
