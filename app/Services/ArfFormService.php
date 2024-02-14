<?php 

namespace App\Services;

use App\Models\Desktop;
use App\Models\Laptop;
use App\Models\LogActivity;
use App\Models\Mobile;
use App\Models\Monitor;
use App\Models\Sim;
use App\Models\Tablet;
use App\Models\ArfForm;
use Illuminate\Support\Facades\Log;

class ArfFormService 
{
    public static function getItems($arfData)
    {
        $items = [];
        $date_issed = now();
        
        if( isset($arfData['has_laptop']) && $arfData['has_laptop'] == 'Y' ) {
            $items[] = ['name' =>'Laptop', 'code' => $arfData['arf_laptop_asset_code'], 'brand' => $arfData['arf_laptop_brand'], 'date_issued' => $date_issed];
        }
        if( isset($arfData['has_monitor']) && $arfData['has_monitor'] == 'Y' ) {
            $items[] = ['name' =>'Monitor', 'code' => $arfData['arf_monitor_asset_code'], 'brand' => $arfData['arf_monitor_brand'], 'date_issued' => $date_issed];
        }
        if( isset($arfData['has_tablet']) && $arfData['has_tablet'] == 'Y' ){
            $items[] = ['name' =>'Tablet', 'code' => $arfData['arf_tablet_asset_code'], 'brand' => $arfData['arf_tablet_brand'], 'date_issued' => $date_issed];
        }
        if( isset($arfData['has_desktop']) && $arfData['has_desktop'] == 'Y' ) {
            $items[] = ['name' =>'Desktop', 'code' => $arfData['arf_desktop_asset_code'], 'brand' => $arfData['arf_desktop_brand'], 'date_issued' => $date_issed];
        }
        if( isset($arfData['has_sim']) && $arfData['has_sim'] == 'Y' ){
            $items[] = ['name' =>'Sim', 'code' => $arfData['arf_sim_asset_code'], 'brand' => $arfData['arf_sim_brand'], 'date_issued' => $date_issed];
        }
        if( isset($arfData['has_mobile']) && $arfData['has_mobile'] == 'Y' ) {
            $items[] = ['name' =>'Mobile', 'code' => $arfData['arf_mobile_asset_code'], 'brand' => $arfData['arf_mobile_brand'], 'date_issued' => $date_issed];
        }
        
        return $items;
    }
    
    public static function registerAssets($arfData, int $arf_id)
    {
        $assets = [];

        if (isset($arfData['has_laptop']) && $arfData['has_laptop'] == 'Y') {
            $assets[] = ['field_name' => 'laptop', 'model_name' => 'Laptop'];
        }
        if (isset($arfData['has_monitor']) && $arfData['has_monitor'] == 'Y') {
            $assets[] = ['field_name' => 'monitor', 'model_name' => 'Monitor'];
        }
        if (isset($arfData['has_tablet']) && $arfData['has_tablet'] == 'Y') {
            $assets[] = ['field_name' => 'tablet', 'model_name' => 'Tablet'];
        }
        if (isset($arfData['has_desktop']) && $arfData['has_desktop'] == 'Y') {
            $assets[] = ['field_name' => 'desktop', 'model_name' => 'Desktop'];
        }
        if (isset($arfData['has_sim']) && $arfData['has_sim'] == 'Y') {
            $assets[] = ['field_name' => 'sim', 'model_name' => 'Sim'];
        }
        if (isset($arfData['has_mobile']) && $arfData['has_mobile'] == 'Y') {
            $assets[] = ['field_name' => 'mobile', 'model_name' => 'Mobile'];
        }

        if (count($assets) > 0) {
            foreach ($assets as $asset) {
                if ($asset['model_name'] == 'Laptop') {
                    $a = Laptop::where('asset_code', $arfData["arf_{$asset['field_name']}_asset_code"])->first();
                } elseif ($asset['model_name'] == 'Monitor') {
                    $a = Monitor::where('asset_code', $arfData["arf_{$asset['field_name']}_asset_code"])->first();
                } elseif ($asset['model_name'] == 'Sim') {
                    $a = Sim::where('asset_code', $arfData["arf_{$asset['field_name']}_asset_code"])->first();
                } elseif ($asset['model_name'] == 'Desktop') {
                    $a = Desktop::where('asset_code', $arfData["arf_{$asset['field_name']}_asset_code"])->first();
                } elseif ($asset['model_name'] == 'Tablet') {
                    $a = Tablet::where('asset_code', $arfData["arf_{$asset['field_name']}_asset_code"])->first();
                } elseif ($asset['model_name'] == 'Mobile') {
                    $a = Mobile::where('asset_code', $arfData["arf_{$asset['field_name']}_asset_code"])->first();
                }

                $a->remarks = $arfData["arf_{$asset['field_name']}_remarks"];
                $a->arf_form_id = $arf_id;
                $a->status = 'Pending Confirmation';
                $a->updated_at = now();
                $a->date_issued = now();

                $a->save();
            }
        }
    }

    public static function unRegisterAssets($arfData, $arf)
    {
        $assets = [];

        if (isset($arfData['has_laptop']) && $arfData['has_laptop'] == 'Y') {
            $assets[] = ['field_name' => 'laptop', 'model_name' => 'Laptop'];
        }
        if (isset($arfData['has_monitor']) && $arfData['has_monitor'] == 'Y') {
            $assets[] = ['field_name' => 'monitor', 'model_name' => 'Monitor'];
        }
        if (isset($arfData['has_tablet']) && $arfData['has_tablet'] == 'Y') {
            $assets[] = ['field_name' => 'tablet', 'model_name' => 'Tablet'];
        }
        if (isset($arfData['has_desktop']) && $arfData['has_desktop'] == 'Y') {
            $assets[] = ['field_name' => 'desktop', 'model_name' => 'Desktop'];
        }
        if (isset($arfData['has_sim']) && $arfData['has_sim'] == 'Y') {
            $assets[] = ['field_name' => 'sim', 'model_name' => 'Sim'];
        }
        if (isset($arfData['has_mobile']) && $arfData['has_mobile'] == 'Y') {
            $assets[] = ['field_name' => 'mobile', 'model_name' => 'Mobile'];
        }

        if (count($assets) > 0) {
            foreach ($assets as $asset) {
                if ($asset['model_name'] == 'Laptop') {
                    $a = Laptop::where('id', $arfData['arf_offboarding_laptop_id'])->where('asset_code', $arfData["arf_{$asset['field_name']}_asset_code"])->first();
                } elseif ($asset['model_name'] == 'Monitor') {
                    $a = Monitor::where('id', $arfData['arf_offboarding_monitor_id'])->where('asset_code', $arfData["arf_{$asset['field_name']}_asset_code"])->first();
                } elseif ($asset['model_name'] == 'Sim') {
                    $a = Sim::where('id', $arfData['arf_offboarding_sim_id'])->where('asset_code', $arfData["arf_{$asset['field_name']}_asset_code"])->first();
                } elseif ($asset['model_name'] == 'Desktop') {
                    $a = Desktop::where('id', $arfData['arf_offboarding_desktop_id'])->where('asset_code', $arfData["arf_{$asset['field_name']}_asset_code"])->first();
                } elseif ($asset['model_name'] == 'Tablet') {
                    $a = Tablet::where('id', $arfData['arf_offboarding_tablet_id'])->where('asset_code', $arfData["arf_{$asset['field_name']}_asset_code"])->first();
                } elseif ($asset['model_name'] == 'Mobile') {
                    $a = Mobile::where('id', $arfData['arf_offboarding_mobile_id'])->where('asset_code', $arfData["arf_{$asset['field_name']}_asset_code"])->first();
                }
                
                if($a){
                    $a->history = $a->history . ", Previous User: [Name: {$arf->name}, Emp_ID: {$arf->emp_id}, Email: {$arf->email}, Status: {$a->status}, Date: {$a->updated_at}]";
                    $a->remarks = null;
                    $a->date_issued = null;
                    $a->arf_form_id = null;
                    $a->updated_at = now();
                    $a->status = 'Active';

                    $a->save();

                    Log::info('### Offboarding - Unregistering Asset Started ###', [
                        'Asset_Type' => $asset['model_name'],
                        'Previous_User' => $arf->name,
                        'Date' => $arf->updated_at,
                        'Asset_Code' => $a->asset_code
                    ]);
                }
            }
        }

        LogActivity::add('Unregister_Asset', json_encode(['Arf_Id' => $arf->id, 'request' => $arfData]), $arf->emp_id, 'Offboarding User Emp ID: ' . $arf->emp_id);
    }
    
    public static function updateAssetStatus(int $arf_id, string $user)
    {
        try {
            $updated = false;

            $arfForm = ArfForm::findOrFail($arf_id);
            
            $laptop = Laptop::select('id', 'asset_code', 'status')->where('arf_form_id', $arf_id)->first();
            $desktop = Desktop::select('id', 'asset_code', 'status')->where('arf_form_id', $arf_id)->first();
            $monitor = Monitor::select('id', 'asset_code', 'status')->where('arf_form_id', $arf_id)->first();
            $tablet = Tablet::select('id', 'asset_code', 'status')->where('arf_form_id', $arf_id)->first();
            $sim = Sim::select('id', 'asset_code', 'status')->where('arf_form_id', $arf_id)->first();
            $mobile = Mobile::select('id', 'asset_code', 'status')->where('arf_form_id', $arf_id)->first();
            
            $logString = '';
            
            if($laptop){
                $laptop->status = 'With User';
                $laptop->updated_at = now();
                $laptop->save();
                
                $logString = 'Laptop Asset Code: ' . $laptop->asset_code;
                
                $updated = true;
            }
            if($desktop){
                $desktop->status = 'With User';
                $desktop->updated_at = now();
                $desktop->save();
                
                $logString .= 'Desktop Asset Code: ' . $desktop->asset_code;
                
                $updated = true;
            }
            if($monitor){
                $monitor->status = 'With User';
                $monitor->updated_at = now();
                $monitor->save();
                
                $logString .= 'Monitor Asset Code: ' . $monitor->asset_code;
                
                $updated = true;
            }
            if($tablet){
                $tablet->status = 'With User';
                $tablet->updated_at = now();
                $tablet->save();
                
                $logString .= 'Tablet Asset Code: ' . $tablet->asset_code;
                
                $updated = true;
            }
            if($sim){
                $sim->status = 'With User';
                $sim->updated_at = now();
                $sim->save();
                
                $logString .= 'Sim Asset Code: ' . $sim->asset_code;
                
                $updated = true;
            }
            if($mobile){
                $mobile->status = 'With User';
                $mobile->updated_at = now();
                $mobile->save();
                
                $logString .= 'Mobile Asset Code: ' . $mobile->asset_code;
                
                $updated = true;
            }
            
           
            if($updated){
                LogActivity::add('Asset_Status_Updated_After_Verification_Success', 'Assets Status have been updated', $arf_id, $user);
            }
            
            return $updated;
            
        } catch(\Exception $exception){
            LogActivity::add('Asset_Status_Updated_After_Verification_Exception', json_encode(Helper::getErrorDetails($exception)), $arf_id, $user);
        }
    }
}