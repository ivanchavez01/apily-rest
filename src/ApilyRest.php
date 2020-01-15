<?php
namespace ApilyRest;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class ApilyRest
{
    protected $models = [];

    public function readModels()
    {
        $files = scandir(app_path());
        foreach ($files as $file) {
            if (strpos($file, ".php") !== false) {
                $this->models[] = str_replace(".php", "", $file);
            }
        }

        return $this;
    }

    public function buildRoutes()
    {
        Route::prefix('api')
            ->middleware(["api"])
            ->namespace("\ApilyRest\Http\Controller")
            ->group(function () {
                foreach ($this->models as $model) {
                    $realModel = Str::snake($model, "-");
                   
                    if ($realModel != "user") {
                        Route::resource($realModel, 'ApilyRestCrudController');
                    }
                }
            });

        Route::get('/api/endpoints', function () {
            foreach ($this->models as $model) {
                $realModel = Str::snake($model, "-");
                   
                if ($realModel != "user") {
                    echo Str::snake($model, "-")."<br>";
                }
            }
        });
    }
}
