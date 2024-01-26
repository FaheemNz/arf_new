<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Monitor;
use Illuminate\Support\Facades\DB;
use App\Models\ArfForm;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MonitorImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        try {
            
            foreach( $rows as $row ){
                $arf = ArfForm::where('name', $row['employeename'])->orWhere('email', $row['email'])->first();

                if( empty($arf) || is_null($arf) ){
                    $arf = ArfForm::create([
                        'emp_id'                =>      $row['employeeid'] ? $row['employeeid'] : '000333',
                        'name'                  =>      $row['employeename'],
                        'email'                 =>      $row['email'] ? $row['email'] : 'noemail@azizidevelopments.com',
                        'department_id'         =>      11,
                        'office_location_id'    =>      7,
                        'created_at'            =>      now(),
                        'updated_at'            =>      now(),
                        'status'                =>      'Acknowledged'
                    ]);
                }

                $monitor = Monitor::where('asset_code', $row['monitor_1'])->where('status', 'Active')->first();

                if( empty($monitor) || is_null($monitor) ){
                    Monitor::create([
                        'asset_brand'       =>      'DESKTOP PC',
                        'arf_form_id'       =>      $arf->id,
                        'status'            =>      'With User',
                        'history'           =>      'Design Department',
                        'asset_serial'      =>      $row['monitor_1'],
                        'asset_code'        =>      $row['monitor_1'],
                        'created_at'        =>      now(),
                        'updated_at'        =>      now()
                    ]);
                } else {
                    $monitor->update([
                        'arf_form_id'       =>      $arf->id,
                        'status'            =>      'With User',
                        'history'           =>      'Design Department',
                        'created_at'        =>      now(),
                        'updated_at'        =>      now()
                    ]);
                }

                
            }

            DB::commit();
        } catch(\Exception $e){
            DB::rollBack();

            dd($e);
        }
    }
}
