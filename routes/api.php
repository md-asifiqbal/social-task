<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\FeedController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    //User Registration route
    Route::post('/auth/register', 'register');
    //User Login route
    Route::post('/auth/login', 'login');
});

//User Page Create
Route::post('/page/create', [PageController::class,'create'])->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->controller(FollowController::class)->group(function () {
    Route::post('/follow/person/{personId}','followPerson');
    Route::post('/follow/page/{pageId}','followPage');
});
Route::middleware('auth:sanctum')->controller(FeedController::class)->group(function () {
    Route::post('/person/attach-post','personAttachPost');
    Route::post('/page/{pageId}/attach-post','pageAttachPost');
    Route::post('/person/feed','feed');
});


