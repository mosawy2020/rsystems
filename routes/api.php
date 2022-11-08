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
| is assigned the "Api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(["namespace" => "Auth"],
    function (){
    Route::post('login',"LoginController@login");
    Route::resource("register","RegisterController")->only("store") ;
}
);
Route::group(["middleware" => "auth:sanctum"],
    function (){
    Route::resource("url","UrlController");
    }
);
Route::get("shortened/{url}","UrlController@shortened") ;
Route::get("html/{url}","UrlController@htmlUrl") ;
