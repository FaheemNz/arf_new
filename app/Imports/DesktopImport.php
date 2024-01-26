<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Desktop;
use Illuminate\Support\Facades\DB;
use App\Models\ArfForm;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DesktopImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        try {
            
            foreach( $rows as $row ){
                $arf = ArfForm::where('name', $row['employeename'])->first();

                if( empty($arf) || is_null($arf) ){
                    $arf = ArfForm::create([
                        'emp_id'                =>      $row['employeeid'] ? $row['employeeid'] : '000222',
                        'name'                  =>      $row['employeename'],
                        'email'                 =>      $row['email'] ? $row['email'] : 'noemail@azizidevelopments.com',
                        'department_id'         =>      11,
                        'office_location_id'    =>      7,
                        'created_at'            =>      now(),
                        'updated_at'            =>      now(),
                        'status'                =>      'Acknowledged'
                    ]);
                }

                $desktop = Desktop::where('asset_code', $row['desktop'])->where('status', 'Active')->first();

                if( empty($desktop) || is_null($desktop) ){
                    Desktop::create([
                        'asset_brand'       =>      'DESKTOP PC',
                        'arf_form_id'       =>      $arf->id,
                        'status'            =>      'With User',
                        'history'           =>      'Design Department',
                        'asset_serial'      =>      $row['desktop'],
                        'asset_code'        =>      $row['desktop'],
                        'created_at'        =>      now(),
                        'updated_at'        =>      now()
                    ]);
                } else {
                    $desktop->update([
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
