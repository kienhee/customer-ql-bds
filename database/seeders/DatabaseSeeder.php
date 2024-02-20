<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'id' => 1,
            'avatar' => 'https://lh3.googleusercontent.com/proxy/S6lTG-RoRrNLwoGkeloceV8t5CPt5P74lp8qty1JaQn3V9ZO9-xQc7IlJbrIDSNrAfJ1ffemUZnoBMG5A8-XHzbPxkXC4nS8BYqG0WKnQuN5XQ',
            'full_name' => 'Trần Trung Kiên',
            'email' => 'kienhee.it@gmail.com',
            'description' => "",
            'facebook' => "",
            'instagram' => "",
            'whatsapp' => "",
            'linkedin' => "",
            'behance' => "",
            'dribbble' => "",
            'phone' => "0376172628",
            'password' => Hash::make('123456'),
            'group_id' => 1,
            'created_at' => Date('y-m-d h:m:s'),
            'updated_at' => Date('y-m-d h:m:s'),
        ]);
       
    }
}
