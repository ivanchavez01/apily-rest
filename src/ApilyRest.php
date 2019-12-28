<?php
namespace ApilyRest;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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
            ->namespace("\ApilyRest\Http\Controller")
            ->group(function () {
                foreach ($this->models as $model) {
                    Route::resource(Str::snake($model, "-"), 'ApilyRestCrudController');
                }
            });

        Route::get('/api/endpoints', function() {
           foreach ($this->models as $model) {
               echo Str::snake($model, "-")."<br>";
           }
        });
    }
}
