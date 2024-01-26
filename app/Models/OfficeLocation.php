<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeLocation extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    
    public function arfForm()
    {
        return $this->hasMany(ArfForm::class, 'arf_form_id');
    }
}
