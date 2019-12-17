<?php
namespace ApilyRest\Facade;

use ApilyRest\ApilyRest as ApilyRestApilyRest;

class ApilyRest
{
    public static function routes()
    {
        return (new ApilyRestApilyRest())
            ->readModels()
            ->buildRoutes();
    }
}