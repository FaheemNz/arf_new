<?php 

namespace App\Services;

class Helper
{
    public static function getErrorDetails(\Exception $exception)
    {
        return [
            'File'      => $exception->getFile(),
            'Message'   => $exception->getMessage(),
            'Line'      => $exception->getLine()
        ];
    }
}