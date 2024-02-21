<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Printer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'printers';
    protected $guarded = [];
    public $allow_export_all = true;
    //public $export_handler = \App\Exports\SimExport::class;

    public function arfForm()
    {
        return $this->belongsTo(ArfForm::class);
    }

    public static function getBrands()
    {
        return ['HP', 'Dell'];
    }
}
