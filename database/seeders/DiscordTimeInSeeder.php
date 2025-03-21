<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DiscordTimeInSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $today = "2025-03-14"; // Get today's date
        DB::table('discord_time_in')->insert([
            [
                'discord_user_id' => "1183775956222099499",
                'discord_username' => "Orland S.",
                'discord_avatar' => "868ed0063635f05c4ac8c3384096e6eb",
                'discord_discriminator' => "0",
                'time_in' => "$today 08:00:00",
                'time_out' => "$today 16:00:00",
            ],
        ]);
    }
}
