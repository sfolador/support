<?php

namespace Sfolador\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Sfolador\Support\Support
 */
class Support extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Sfolador\Support\Support::class;
    }
}
