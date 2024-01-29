<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DirectionsSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
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
