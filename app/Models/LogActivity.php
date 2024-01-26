<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    
    public static function add(string $event, string $details, int $arf_form_id, string $user)
    {
        return self::create([
            'event'         =>  $event,
            'details'       =>  $details,
            'arf_form_id'   =>  $arf_form_id,
            'user'          =>  $user
        ]);
    }
}
