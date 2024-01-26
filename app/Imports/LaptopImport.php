<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\ArfForm;
use App\Models\Laptop;
use Illuminate\Support\Facades\DB;

class LaptopImport implements ToCollection, WithHeadingRow
{
    private $rowCount = 0;
    private $importLimit = 5;

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        try {
            DB::beginTransaction();

            foreach ($rows as $row) {
                $this->rowCount++;

                if ($this->rowCount > $this->importLimit) {
                    break;
                }

                $arf = ArfForm::create([
                    'emp_id'                =>      $row['emp_id'],
                    'name'                  =>      $row['emp_name'],
                    'email'                 =>      $row['email'],
                    'department_id'         =>      $row['department_id'],
                    'office_location_id'    =>      $row['office_location_id'],
                    'status'                =>      'Acknowledged'
                ]);

                Laptop::create([
                    'arf_form_id' => $arf->id,
                    'status' => 'With User',
                    'remarks' => $row['remarks'],
                    'asset_code' => $row['asset_code'],
                    'history' => $row['history']
                ]);
            }
            DB::commit();
        } catch(\Exception $exception){
            DB::rollBack();
            dd($exception);
        }
    }
}
