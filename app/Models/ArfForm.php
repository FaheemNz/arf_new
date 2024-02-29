<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArfForm extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    public $additional_attributes = ['details'];

    protected $with = ['laptops', 'sims', 'tablets', 'monitors', 'desktops', 'mobiles', 'printers'];

    public $allow_export_all = true;
    public $export_handler = \App\Exports\ArfFormExport::class;
    
    // Relationships
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function officeLocation()
    {
        return $this->belongsTo(OfficeLocation::class);
    }
    public function laptops()
    {
        return $this->hasMany(Laptop::class, 'arf_form_id');
    }
    public function tablets()
    {
        return $this->hasMany(Tablet::class, 'arf_form_id');
    }
    public function sims()
    {
        return $this->hasMany(Sim::class, 'arf_form_id');
    }
    public function monitors()
    {
        return $this->hasMany(Monitor::class, 'arf_form_id');
    }
    public function desktops()
    {
        return $this->hasMany(Desktop::class, 'arf_form_id');
    }
    public function mobiles()
    {
        return $this->hasMany(Mobile::class, 'arf_form_id');
    }
    public function printers()
    {
        return $this->hasMany(Printer::class, 'arf_form_id');
    }

    // Methods
    public static function saveData(array $arfData)
    {
        return self::create(
            [
                'emp_id'                =>      $arfData['arf_emp_id'],
                'office_location_id'    =>      $arfData['arf_office_location'],
                'department_id'         =>      $arfData['arf_dept'],
                'name'                  =>      $arfData['arf_name'],
                'email'                 =>      $arfData['arf_email'],
                'contact_details'       =>      $arfData['arf_contact_details']
            ]
        );
    }
    public static function getLaptopBrands()
    {
        return ['HP', 'Fujitsu', 'Lenovo', 'Dell', 'Macbook', 'iMac'];
    }
    public static function getTabletBrands()
    {
        return ['Apple', 'Samsung'];
    }
    public static function getMonitorBrands()
    {
        return ['HP', 'Dell', 'Fujitsu', 'Lenovo', 'Apple', 'Samsung', 'Asus'];
    }
    public static function getSimNetworks()
    {
        return ['DU', 'Etisilat'];
    }
    public static function getDesktopBrands()
    {
        return ['HP', 'Dell', 'Apple'];
    }

    public static function getPrinterBrands()
    {
        return ['HP', 'Dell'];
    }

    // Accessors
    public function getDetailsAttribute()
    {
        return "Arf Form: {$this->id} ::: Username: {$this->name} ::: Emp ID:{$this->emp_id}";
    }
}
