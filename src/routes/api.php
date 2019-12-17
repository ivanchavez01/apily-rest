<?php

Route::group(["namespace" => "ApilyRest\Http\Controller"], function () {
    Route::get('/', 'ApilyRestCrudController@index');
});
