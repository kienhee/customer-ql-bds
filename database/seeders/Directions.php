<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Directions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $directions = [
            ['name' => 'Đông'],
            ['name' => 'Tây'],
            ['name' => 'Nam'],
            ['name' => 'Bắc'],
            ['name' => 'Đông Bắc'],
            ['name' => 'Đông Nam'],
            ['name' => 'Tây Nam'],
            ['name' => 'Tây Bắc'],
        ];

        // Insert data into the 'directions' table
        DB::table('directions')->insert($directions);
    }
}
