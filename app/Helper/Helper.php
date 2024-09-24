<?php

namespace App\Helper;

class Helper
{
    public static function Display($request)
    {
        echo "</pre>";
        print_r($request);
        echo "</pre>";
        exit();
    }
}
