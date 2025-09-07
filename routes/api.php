<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::namespace('App\Http\Controllers\Web')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('/logout', 'AuthController@logout');

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/region', 'LocationController@region');
        Route::get('/province', 'LocationController@province');
        Route::get('/city', 'LocationController@city');
        Route::get('/barangay', 'LocationController@barangay');

        Route::apiResources([
            'roles-and-permissions' => 'PermissionsController',
            'maintenance' => 'MaintenanceController'
        ]);

     });

});
