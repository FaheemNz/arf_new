<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sim extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    public $allow_export_all = true;
    public $export_handler = \App\Exports\SimExport::class;

    public function arfForm()
    {
        return $this->belongsTo(ArfForm::class);
    }

    public static function getBrands()
    {
        return ['DU', 'Etisilat'];
    }
}
