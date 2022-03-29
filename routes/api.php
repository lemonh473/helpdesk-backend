<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'v1',
    'namespace' => 'App\Http\Controllers\API'
], function () {
    // Register
    Route::post('register', 'AuthController@register');
    // Login
    Route::post('login', 'AuthController@login');
    
    // Token refresh
    Route::get('refresh', 'AuthController@refresh');

    // Send issue
    Route::post('issues', 'IssueController@store');
    
    // Auth routes
    Route::middleware('auth:api')->group(function () {
        Route::post('logout', 'AuthController@logout');

        // Issue
        Route::get('issues', 'IssueController@getList');
        Route::get('issues/edit/{issue}', 'IssueController@edit');
        Route::put('issues/{issue}', 'IssueController@update');
    });
});
