<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Verification extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    
    public static function getToken()
    {
        return sha1(uniqid(time(), true));
    }
    
    public static function register(string $token, int $arf_form_id, string $email)
    {
        return self::create([
            'token' => $token,
            'arf_form_id' => $arf_form_id,
            'remarks' => 'Email sent to: ' . $email 
        ]);
    }

    public static function getUrl($token)
    {
        return 'http://5.195.13.174:57134/verify/' . $token;
    }
    
    public static function getReplacementUrl($token)
    {
        return 'http://5.195.13.174:57134/replace/verify' . $token;
    }
}
