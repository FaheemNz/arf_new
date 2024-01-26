<?php

namespace App\Exports;

use Tu6ge\VoyagerExcel\Exports\BaseExport;
use App\Models\ArfForm;

class ArfFormExport extends BaseExport
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
        $arfForms = ArfForm::get();

        $arfForms->transform(function($arfForm) {
            $arfFormArray = $arfForm->toArray();

            $arfFormArray['Tablet'] = '';
            $arfFormArray['Laptop'] = '';
            $arfFormArray['Desktop'] = '';
            $arfFormArray['Monitor'] = '';
            $arfFormArray['Sim'] = '';
            $arfFormArray['Mobile'] = '';

            unset($arfFormArray['tablets']);
            unset($arfFormArray['laptops']);
            unset($arfFormArray['desktops']);
            unset($arfFormArray['monitors']);
            unset($arfFormArray['mobiles']);
            unset($arfFormArray['sims']);
            
            if(isset($arfForm->tablets) && count($arfForm->tablets) > 0){
                $arfFormArray['Tablet'] = $arfForm->tablets[0]->asset_code;
            }
            if(isset($arfForm->laptops) && count($arfForm->laptops) > 0){
                $arfFormArray['Laptop'] = $arfForm->laptops[0]->asset_code;
            }
            if(isset($arfForm->desktops) && count($arfForm->desktops) > 0){
                $arfFormArray['Desktop'] = $arfForm->desktops[0]->asset_code;
            }
            if(isset($arfForm->monitors) && count($arfForm->monitors) > 0){
                $arfFormArray['Monitor'] = $arfForm->monitors[0]->asset_code;
            }
            if(isset($arfForm->sims) && count($arfForm->sims) > 0){
                $arfFormArray['Sim'] = $arfForm->sims[0]->asset_code;
            }
            if(isset($arfForm->mobiles) && count($arfForm->mobiles) > 0){
                $arfFormArray['Mobile'] = $arfForm->mobiles[0]->asset_code;
            }
            
            return $arfFormArray;
        });
        
        $arfForms->prepend($this->headings());

        return $arfForms;
    }
    
    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Email',
            'Contact_Details',
            'Employee_ID',
            'Status',
            'Department_ID',
            'Office_Location_ID',
            'Created_At',
            'Updated_At',
            'Tablet',
            'Laptop',
            'Desktop',
            'Monitor',
            'Sim',
            'Mobile'
        ];
    }
}
