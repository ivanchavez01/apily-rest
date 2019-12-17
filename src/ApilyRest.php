<?php
namespace ApilyRest;

use Illuminate\Support\Facades\Route;

class ApilyRest
{
    private $modelPath = "app";
    protected $models = [];

    public function readModels()
    {
        $files = scandir(app_path());
        foreach ($files as $file) {
            if (strpos($file, ".php") !== FALSE) {
                $this->models[] = str_replace(".php", "", $file);
            }
        }

        return $this;
    }

    public function buildRoutes()
    {
        Route::prefix('api')
            ->middleware(["api"])
            ->group(function () {
                foreach ($this->models as $model) {
                    Route::resource(strtolower($model), 'Api\ApilyRestCrudController');
                }
            });
    }
}