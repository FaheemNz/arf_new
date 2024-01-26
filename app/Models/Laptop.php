<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laptop extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $guarded = [];
    public $allow_export_all = true;
    public $export_handler = \App\Exports\LaptopExport::class;

    public function arfForm()
    {
        return $this->belongsTo(ArfForm::class);
    }

    public static function getBrands()
    {
        return ['Fujitsu', 'Lenovo', 'HP', 'Dell', 'Apple'];
    }
}
