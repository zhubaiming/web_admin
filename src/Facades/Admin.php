<?php

namespace Toolman\Admin\Facades;

use Illuminate\Support\Facades\Facade;

class Admin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Toolman\Admin\Admin::class;
    }
}
