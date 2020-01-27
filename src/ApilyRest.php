<?php
namespace ApilyRest;

use Illuminate\Support\Facades\Cache;
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
        $scopes = [];

        Route::prefix('api')
            ->middleware(["api"])
            ->namespace("\ApilyRest\Http\Controller")
            ->group(function () {
                foreach ($this->models as $model) {
                    $realModel = Str::snake($model, "-");
                    
                    if ($realModel != "user") {
                        $scope = "{$realModel}-get";
                        $scopes[] = $scope;

                        Route::get($realModel, 'ApilyRestCrudController@index')
                            ->middleware(['scope:'.$scope]);
                        
                        $scope = "{$realModel}-show";
                        $scopes[] = $scope;
                        Route::get($realModel."/{id}", 'ApilyRestCrudController@show')
                            ->middleware(['scope:'.$scope]);

                        $scope = "{$realModel}-update";
                        $scopes[] = $scope;
                        Route::put($realModel."/{id}", 'ApilyRestCrudController@update')
                            ->middleware(['scope:'.$scope]);

                        $scope = "{$realModel}-create";
                        $scopes[] = $scope;
                        Route::post($realModel, 'ApilyRestCrudController@create')
                            ->middleware(['scope:'.$scope]);
                        
                        $scope = "{$realModel}-delete";
                        $scopes[] = $scope;
                        Route::delete($realModel, 'ApilyRestCrudController@create')
                            ->middleware(['scope:'.$scope]);
                    }
                }

                Cache::put('apilyrest-scopes', $scopes);
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
