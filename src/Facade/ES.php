<?php

namespace Neox\Ramen\Elastic\Facade;

use Illuminate\Support\Facades\Facade;

class ES extends Facade
{
    protected static function getFacadeAccessor() { return 'es'; }
}
