<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfficeLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('office_locations')->insert([
          ['name' => '5th Floor'],
          ['name' => '8th Floor'],
          ['name' => '12th Floor'],
          ['name' => '13th Floor'],
          ['name' => '14th Floor'],
          ['name' => '15th Floor'],
          ['name' => 'Site']  
        ]);
    }
}
