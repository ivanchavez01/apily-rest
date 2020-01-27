<?php
namespace ApilyRest\Facade;

use ApilyRest\ApilyRest as ApilyRestApilyRest;
use Illuminate\Support\Facades\Cache;

class ApilyRest
{
    public static function routes()
    {
        return (new ApilyRestApilyRest())
            ->readModels()
            ->buildRoutes();
    }

    public static function tokenScopes() {
        return Cache::get('apilyrest-scopes');
    }
}