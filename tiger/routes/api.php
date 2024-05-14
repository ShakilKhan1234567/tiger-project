<?php

use App\Http\Controllers\API\CategoryApiController;
use App\Http\Controllers\API\CustomerauthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// api customer Authentication
Route::post('/customer/register/api', [CustomerauthenticationController::class, 'api_customer_register']);
Route::post('/customer/login', [CustomerauthenticationController::class, 'customer_login']);
Route::post('/customer/logout', [CustomerauthenticationController::class, 'customer_logout']);

// create api
Route::get('/get/category', [CategoryApiController::class, 'get_category']);

// api crud operation
Route::middleware('auth:sanctum')->group( function () {
    Route::post('/category/store', [CategoryApiController::class, 'category_store']);
    Route::get('/category/show/{id}', [CategoryApiController::class, 'category_show']);
    Route::post('/category/update/{id}', [CategoryApiController::class, 'category_update']);
    Route::get('/category/delete/{id}', [CategoryApiController::class, 'category_delete']);
    Route::get('/category/permanent/delete/{id}', [CategoryApiController::class, 'category_permanent_delete']);
});
