<?php

namespace Database\Seeders;

use App\Models\Desktop;
use App\Models\Laptop;
use App\Models\Tablet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = strtotime(date('Y-m-d'));
        
        $laptops = [];
        $tablets = [];
        $desktops = [];
        
        for($i=1100; $i<=1160; $i++){
            $laptops[] = [
                'asset_code'  => 'AZLAP' . $i,
                'asset_brand' => 'Fujitsu',
                'date_issued' => $date
            ];
            $desktops[] = [
                'asset_code'  => 'AZDTC' . $i,
                'asset_brand' => 'HP',
                'date_issued' => $date
            ];
            $tablets[] = [
                'asset_code'  => 'ATA' . $i,
                'asset_brand' => 'Apple',
                'date_issued' => $date
            ];
        }
        
        // DB::table('laptops')->insert($laptops);
        // DB::table('desktops')->insert($desktops);
        // DB::table('tablets')->insert($tablets);
    }
}
