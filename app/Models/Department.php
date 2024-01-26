<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    
    public function arfForms()
    {
        return $this->hasMany(ArfForm::class, 'department_id');
    }
}
