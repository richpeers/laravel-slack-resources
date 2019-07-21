<?php

// api routes
Route::prefix('api')->group(function () {
    Route::group(['middleware' => ['api']], function () {

        Route::post(
            '/resources',
            '\Richpeers\LaravelSlackResources\Http\Controllers\SlackCommandController@store'
        )->middleware('slack-resource');
    });
});
