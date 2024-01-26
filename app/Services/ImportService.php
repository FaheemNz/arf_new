<?php 

namespace App\Services;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\Helper;
use Illuminate\Support\Facades\DB;
use App\Models\Desktop;
use App\Models\Laptop;
use App\Models\Mobile;
use App\Models\Tablet;
use App\Models\Monitor;
use Illuminate\Support\Facades\Mail;

class ImportService {

    public static function getAssets(){

        $importFromDate = strtotime(setting('admin.asset_import_days_offset'));
        $epmsUrl = setting('admin.asset_import_epms_url');
        
        try {
            $responseLaptops = Http::get(  $epmsUrl . '?Category=Laptop');
            $responseDesktops = Http::get( $epmsUrl . '?Category=Desktop+PC');
            $responseMonitors = Http::get( $epmsUrl . '?Category=Monitor');
            $responseMobiles = Http::get(  $epmsUrl . '?Category=Mobile+Phone');
            $responseTablets = Http::get(  $epmsUrl . '?Category=Tablets');

            if( $responseLaptops->successful() ){
                $laptops = $responseLaptops->json();
                $toInsertLaptops = [];

                foreach( $laptops as $asset ){
                    if( strtotime($asset['CreatedOn']) >= $importFromDate ){
                        $toInsertLaptops[] = [
                            'asset_code'    => $asset['AssetNo'],
                            'asset_brand'   => $asset['Description'],
                            'asset_serial'  => $asset['SerialNo'],
                            'company'       => $asset['Company'],
                            'created_at'    => now(),
                            'updated_at'    => now()
                        ];
                    }
                }
                
                try {
                    Laptop::upsert($toInsertLaptops, ['asset_code']);
                } catch(\Exception $exception){
                    Log::info('### Import Error - Laptops ###', [
                        'Time'          => now(),
                        'Exception'     => json_encode(Helper::getErrorDetails($exception)),
                    ]);
                }
            }

            if( $responseDesktops->successful() ){
                $desktops = $responseDesktops->json();
                $toInsertDesktops = [];

                foreach( $desktops as $asset ){
                    if( strtotime($asset['CreatedOn']) >= $importFromDate ){
                        $toInsertDesktops[] = [
                            'asset_code'    => $asset['AssetNo'],
                            'asset_brand'   => $asset['Description'],
                            'asset_serial'  => $asset['SerialNo'],
                            'company'       => $asset['Company'],
                            'created_at'    => now(),
                            'updated_at'    => now()
                        ];
                    }
                }

                try {
                    Desktop::upsert($toInsertDesktops, ['asset_code']);
                } catch(\Exception $exception){
                    Log::info('### Import Error - Desktops ###', [
                        'Time'          => now(),
                        'Exception'     => json_encode(Helper::getErrorDetails($exception)),
                    ]);
                }
            }

            if( $responseMonitors->successful() ){
                $monitors = $responseMonitors->json();
                $toInsertMonitors = [];

                foreach( $monitors as $asset ){
                    if( strtotime($asset['CreatedOn']) >= $importFromDate ){
                        $toInsertMonitors[] = [
                            'asset_code'    => $asset['AssetNo'],
                            'asset_brand'   => $asset['Description'],
                            'asset_serial'  => $asset['SerialNo'],
                            'company'       => $asset['Company'],
                            'created_at'    => now(),
                            'updated_at'    => now()
                        ];
                    }
                }

                try {
                    Monitor::upsert($toInsertMonitors, ['asset_code']);
                } catch(\Exception $exception){
                    Log::info('### Import Error - Monitor ###', [
                        'Time'          => now(),
                        'Exception'     => json_encode(Helper::getErrorDetails($exception)),
                    ]);
                }
            }

            if( $responseMobiles->successful() ){
                $mobiles = $responseMobiles->json();
                $toInsertMobiles = [];

                foreach( $mobiles as $asset ){
                    if( strtotime($asset['CreatedOn']) >= $importFromDate ){
                        $toInsertMobiles[] = [
                            'asset_code'    => $asset['AssetNo'],
                            'asset_brand'   => $asset['Description'],
                            'asset_serial'  => $asset['SerialNo'],
                            'company'       => $asset['Company'],
                            'created_at'    => now(),
                            'updated_at'    => now()
                        ];
                    }
                }

                try {
                    Mobile::upsert($toInsertMobiles, ['asset_code']);
                } catch(\Exception $exception){
                    Log::info('### Import Error - Mobile ###', [
                        'Time'          => now(),
                        'Exception'     => json_encode(Helper::getErrorDetails($exception)),
                    ]);
                }
            }

            if( $responseTablets->successful() ){
                $tablets = $responseTablets->json();
                $toInsertTablets = [];

                foreach( $tablets as $asset ){
                    if( strtotime($asset['CreatedOn']) >= $importFromDate ){
                        $toInsertMobiles[] = [
                            'asset_code'    => $asset['AssetNo'],
                            'asset_brand'   => $asset['Description'],
                            'asset_serial'  => $asset['SerialNo'],
                            'company'       => $asset['Company'],
                            'created_at'    => now(),
                            'updated_at'    => now()
                        ];
                    }
                }

                try {
                    Tablet::upsert($toInsertTablets, ['asset_code']);
                } catch(\Exception $exception){
                    Log::info('### Import Error - Tablet ###', [
                        'Time'          => now(),
                        'Exception'     => json_encode(Helper::getErrorDetails($exception)),
                    ]);
                }
            }

            Log::info('### Import Success', [
                'Time'          => now(),
                'Message'       => 'Import has been successful.'
            ]);
        } catch(\Exception $exception){
            Log::info('### Import Error ###', [
                'Time'          => now(),
                'Exception'     => json_encode(Helper::getErrorDetails($exception)),
            ]);

            Mail::to(env('ERROR_EMAIL_NOTIFIER'))
                ->send(new ArfNotification($this->details));
        }
    }
}