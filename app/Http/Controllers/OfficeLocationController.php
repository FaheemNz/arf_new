<?php

namespace App\Http\Controllers;

use App\Models\ArfForm;

class OfficeLocationController extends Controller
{
    protected $guarded = [];
    
    public function arfForm()
    {
        return $this->hasMany(ArfForm::class);
    }
}
