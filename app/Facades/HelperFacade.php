<?php

namespace App\Facades;

use illuminate\Support\Facades\Facade;

class HelperFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'helper'; // Your custom helper class name
    }
}