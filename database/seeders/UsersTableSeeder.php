<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        // Use Faker to generate 100 users with a time gap of approximately 2 minutes
        $faker = Faker::create();
        $currentTime = now();


        for ($i = 1; $i <= 100; $i++) {
            $users[] = [
                'avatar' => 'https://picsum.photos/100/100', // Placeholder line image URL from Lorem Picsum
                'full_name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'description' => $faker->sentence,
                'phone' => $faker->phoneNumber,
                'facebook' => $faker->url,
                'instagram' => $faker->url,
                'whatsapp' => $faker->phoneNumber,
                'linkedin' => $faker->url,
                'behance' => $faker->url,
                'dribbble' => $faker->url,
                'group_id' => 1,
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'remember_token' => null,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ];

            // Add 2 minutes for the next user
            $currentTime->addMinutes(2);
        }
        // Seed the users table
        DB::table('users')->insert($users);
    }
}
