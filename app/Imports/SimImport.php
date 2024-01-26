<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\ArfForm;
use App\Models\Sim;
use Illuminate\Support\Facades\DB;

class SimImport implements ToCollection, WithHeadingRow
{

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        try {
            
            foreach( $rows as $row ){
                $arf = ArfForm::where('name', $row['account_holder'])->orWhere('emp_id', $row['emp_id'])->first();

                if( empty($arf) || is_null($arf) ){
                    $arf = ArfForm::create([
                        'emp_id'                =>      $row['emp_id'] ? $row['emp_id'] : '000555',
                        'name'                  =>      $row['account_holder'],
                        'email'                 =>      $row['email'] ? $row['email'] : 'noemailgardinia@azizidevelopments.com',
                        'department_id'         =>      11,
                        'office_location_id'    =>      7,
                        'created_at'            =>      now(),
                        'updated_at'            =>      now(),
                        'status'                =>      'Acknowledged'
                    ]);
                }

                $sim = Sim::where('asset_code', $row['account_number'])->where('status', 'Active')->first();

                if( empty($sim) || is_null($sim) ){
                    Sim::create([
                        'asset_brand'       =>      'DU',
                        'arf_form_id'       =>      $arf->id,
                        'status'            =>      'With User',
                        'history'           =>      $row['previous_user'],
                        'asset_serial'      =>      $row['serial_no'],
                        'asset_code'        =>      $row['account_number'],
                        'created_at'        =>      now(),
                        'updated_at'        =>      now()
                    ]);
                } else {
                    $sim->update([
                        'arf_form_id'       =>      $arf->id,
                        'status'            =>      'With User',
                        'history'           =>      'Gardinia',
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

    // /**
    // * @param Collection $collection
    // */
    // public function collection(Collection $rows)
    // {
    //     // Landline, Biometric, Executive Office, Sales Department
    //     try {
    //         DB::beginTransaction();
    //         // $i = 1;

    //         // foreach( $rows as $row ){
    //         //     if( $row['dept_id'] == 'Sales Department' || $row['dept_id'] == 'Sales' ){
    //         //        echo $row['emp_name'];
    //         //        $i++;
    //         //     }
    //         // }

    //         // echo $i;

    //         // dd('Done');

    //         // return;

    //         foreach ($rows as $row) {
    //             if( in_array($row['dept_id'], ['LANDLINE', 'BIOMETRIC', 'Executive Office', 'Sales Department', 'Sales']) ){
    //                 continue;
    //             }

    //             if( $row['dept_id'] == null || empty($row['dept_id']) || empty( $row['emp_name'] ) || $row['emp_name'] == null ){
    //                 continue;
    //             }

    //             $dept = '';
    //             $ol = '';

    //             if( $row['dept_id'] == 'VCM' || $row['dept_id'] == 'VCM Department' ){
    //                 $dept = 4;
    //                 $ol = 5;
    //             } else if($row['dept_id'] == 'Sales & Marketing'){
    //                 $dept = 5;
    //                 $ol = 5;
    //             } else if( $row['dept_id'] == 'Administration Department' || $row['dept_id'] == 'TRANSPORTATION' ){
    //                 $dept = 19;
    //                 $ol = 2;
    //             } else if( $row['dept_id'] == 'Management' || $row['dept_id'] == "Chairman's Office" ){
    //                 $dept = 21;
    //                 $ol = 1;
    //             } else if( $row['dept_id'] == 'Techtiq Department' || $row['dept_id'] == 'Techtiq' || $row['dept_id'] == 'Techtiq BMS' ){
    //                 $dept = 7;
    //                 $ol = 5;
    //             } else if( $row['dept_id'] == 'Operations Management' ){
    //                 $dept = 20;
    //                 $ol = 5;
    //             } else if( $row['dept_id'] == 'Marketing Department' || $row['dept_id'] == 'Marketing and Communication' ){
    //                 $dept = 17;
    //                 $ol = 5;
    //             } else if( $row['dept_id'] == 'Procurement Department' || $row['dept_id'] == 'Procurement dEPT' || $row['dept_id'] == 'Procurement' ){
    //                 $dept = 12;
    //                 $ol = 5;
    //             } else if( $row['dept_id'] == 'HandOver Department' ){
    //                 $dept = 14;
    //                 $ol = 5;
    //             }  else if( $row['dept_id'] == 'Audit Department' ){
    //                 $dept = 2;
    //                 $ol = 5;
    //             } else if( in_array($row['dept_id'], ['PMO', 'Project Management Office']) ){
    //                 $dept = 10;
    //                 $ol = 5;
    //             } else if( $row['dept_id'] == 'Leasing Department' ){
    //                 $dept = 34;
    //                 $ol = 5;
    //             } else if( $row['dept_id'] == 'CRM Department' ){
    //                 $dept = 7;
    //                 $ol = 5;
    //             } else if( $row['dept_id'] == 'Asset Department' ){
    //                 $dept = 1;
    //                 $ol = 5;
    //             } else if( $row['dept_id'] == 'Agency Department' || $row['dept_id'] == 'Agency' ){
    //                 $dept = 15;
    //                 $ol = 5;
    //             } else if( $row['dept_id'] == 'Mortgage Department' || $row['dept_id'] == 'Mortgage' ){
    //                 $dept = 36;
    //                 $ol = 5;
    //             } else if( $row['dept_id'] == 'Telesales' ){
    //                 $dept = 16;
    //                 $ol = 5;
    //             } else if( in_array($row['dept_id'], ['Customer Care Department', 'CRM', 'Customer Care', 'CRM Department', 'Customer Service Department', 
    //                     'Customer Service', 'Collection Department', 'Contracts Department']) ){
    //                 $dept = 28;
    //                 $ol = 5;
    //             } else if( $row['dept_id'] == 'Documentation' || $row['dept_id'] == 'Contracts & Documentation Department' || $row['dept_id'] == 'Documentation Dept' ){
    //                 $dept = 29;
    //                 $ol = 5;
    //             } else if( $row['dept_id'] == 'Construction Department' || $row['dept_id'] == 'Supervision Department' || $row['dept_id'] == 'Gardinia' ){
    //                 $dept = 11;
    //                 $ol = 5;
    //             } else if( in_array($row['dept_id'], ['Engineering Management', 'Design Department', 'Engineering-Hotel Division Dept', 'Supervision Department', 
    //                     'Construction', 'Engineering Department', 'Engineering Cluster', 'DLP', 'Design', 'Engineering - Construction', 'Projects Office Department']) ){
    //                 $dept = 45;
    //                 $ol = 5;
    //             } else if( $row['dept_id'] == 'Hospitality Division' ){
    //                 $dept = 46;
    //                 $ol = 5;
    //             } else if( in_array($row['dept_id'], ['Finance', 'Finance Department'])){
    //                 $dept = 13;
    //                 $ol = 5;
    //             } else if( in_array($row['dept_id'], ['HR', 'Human Resources', 'Human Resources Department', 'HR & Admin Department'])){
    //                 $dept = 32;
    //                 $ol = 5;
    //             } else if( in_array($row['dept_id'], ['Training', 'Training Department'])){
    //                 $dept = 37;
    //                 $ol = 5;
    //             } else if( in_array($row['dept_id'], ['IT Department']) ){
    //                 $dept = 18;
    //                 $ol = 5;
    //             } else if( in_array($row['dept_id'], ['Legal Department', 'Legal']) ){
    //                 $dept = 35;
    //                 $ol = 5;
    //             } else if( in_array($row['dept_id'], ['SECURITY', 'Security Department']) ){
    //                 $dept = 26;
    //                 $ol = 4;
    //             } else if( in_array($row['dept_id'], ['Facility Management Department', 'FM DEPARTMENT', 'Legacious FM', 'Techtiq & Legacious']) ){
    //                 $dept = 8;
    //                 $ol = 5;
    //             } else {
    //                 $dept = 47;
    //                 $ol = 8;
    //             }

    //             $arf = ArfForm::where('name', $row['emp_name'])->first();

    //             if( empty($arf) || is_null($arf) ){
    //                 $arf = ArfForm::create([
    //                     'emp_id'                =>      $row['emp_code'] ? $row['emp_code'] : '000111',
    //                     'name'                  =>      $row['emp_name'],
    //                     'email'                 =>      $row['emp_email'] ? $row['emp_email'] : 'noemail@azizidevelopments.com',
    //                     'department_id'         =>      $dept,
    //                     'office_location_id'    =>      $ol,
    //                     'status'                =>      'Acknowledged'
    //                 ]);
    //             }

    //             Sim::create([
    //                 'asset_brand'       =>      $row['asset_brand'],
    //                 'arf_form_id'       =>      $arf->id,
    //                 'status'            =>      'With User',
    //                 'history'           =>      'Sales Department',
    //                 'asset_serial'      =>      $row['asset_serial'],
    //                 'asset_code'        =>      $row['asset_code']
    //             ]);
    //         }
    //         DB::commit();
    //     } catch(\Exception $exception){
    //         DB::rollBack();
    //         dd($exception);
    //     }
    // }
}
