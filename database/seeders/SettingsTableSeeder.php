<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            'id' => '1',
            'email' => 'example@example.com',
            'phone' => '123-456-7890',
            'address' => '123 Main St, City',
            'facebook' => 'https://www.facebook.com/example',
            'twitter' => 'https://twitter.com/example',
            'instagram' => 'https://www.instagram.com/example',
            'linkedin' => 'https://www.linkedin.com/in/example',
            'isCalendar' => true,
            'isKanban' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
