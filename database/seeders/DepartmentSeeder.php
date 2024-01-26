<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            ['name' => 'Asset', 'created_at' => now()],
            ['name' => 'Audit', 'created_at' => now()],
            ['name' => 'CRM', 'created_at' => now()],
            ['name' => 'VCM', 'created_at' => now()],
            ['name' => 'Sales', 'created_at' => now()],
            ['name' => 'Sales Admin', 'created_at' => now()],
            ['name' => 'Techtiq', 'created_at' => now()],
            ['name' => 'Legacious', 'created_at' => now()],
            ['name' => 'Engineering', 'created_at' => now()],
            ['name' => 'PMO', 'created_at' => now()],
            ['name' => 'Gardinia', 'created_at' => now()],
            ['name' => 'Procurement', 'created_at' => now()],
            ['name' => 'Finance', 'created_at' => now()],
            ['name' => 'Handover', 'created_at' => now()],
            ['name' => 'Agency', 'created_at' => now()],
            ['name' => 'Telesales', 'created_at' => now()],
            ['name' => 'Marketing', 'created_at' => now()],
            ['name' => 'IT', 'created_at' => now()],
            ['name' => 'Administration', 'created_at' => now()],
            ['name' => 'Operation', 'created_at' => now()]
        ]);
    }
}
