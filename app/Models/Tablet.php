<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tablet extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    public $allow_export_all = true;
    public $export_handler = \App\Exports\TabletExport::class;

    protected $guarded = [];

    public function arfForm()
    {
        return $this->belongsTo(ArfForm::class);
    }

    public static function getBrands()
    {
        return ['Samsung', 'Apple', 'Microsoft'];
    }
}
