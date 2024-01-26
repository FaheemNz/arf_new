<?php 

namespace App\Exports;

use Tu6ge\VoyagerExcel\Exports\BaseExport;
use App\Models\Tablet;

class TabletExport extends BaseExport
{
    protected $dataType;
    protected $model;

    public function __construct($dataType, array $ids)
    {
        $this->dataType = $dataType;
        $this->model = new $dataType->model_name();
    }

    public function collection()
    {
        $tablets = Tablet::with('arfForm')->get();
        
        $tablets->transform(function($tablet) {
            $tabletData = [];

            $tabletData[] = [
                $tablet->id,
                $tablet->arfForm ? $tablet->arfForm->emp_id : '',
                $tablet->arfForm ? $tablet->arfForm->name : '',
                $tablet->arfForm ? $tablet->arfForm->email : '',
                $tablet->asset_code,
                $tablet->asset_serial,
                $tablet->asset_brand,
                $tablet->date_issued,
                $tablet->remarks,
                $tablet->history,
                $tablet->status,
                $tablet->arf_form_id,
                $tablet->created_at,
                $tablet->updated_at,
                $tablet->company
            ];


            return $tabletData;
        });
        
        $tablets->prepend($this->headings());
        
        return $tablets;
    }
    
    public function headings(): array
    {
        return [
            '#',
            'Emp_ID',
            'Emp_Name',
            'Email',
            'Asset_Code',
            'Asset_Serial',
            'Asset_Brand',
            'Date_Issued',
            'Remarks',
            'History',
            'Status',
            'Arf_Form_ID',
            'Created_Date',
            'Updated_Date',
            'Company'
        ];
    }
}