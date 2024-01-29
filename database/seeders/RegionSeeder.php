<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $regions = [
            ['name' => 'Miền Bắc'],
            ['name' => 'Miền Trung'],
            ['name' => 'Miền Nam'],
        ];

        DB::table('regions')->insert($regions);
    }
}
