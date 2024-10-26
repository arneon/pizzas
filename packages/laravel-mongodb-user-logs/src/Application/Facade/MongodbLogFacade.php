<?php

namespace Arneon\MongodbUserLogs\Application\Facade;

use Illuminate\Support\Facades\Facade;

class MongodbLogFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'MongodbLog';
    }

}
