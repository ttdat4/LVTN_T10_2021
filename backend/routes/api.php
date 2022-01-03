<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserApiController;
use App\Http\Controllers\CategoryApiController;
use App\Http\Controllers\SupplierApiController;
use App\Http\Controllers\ProductApiController;
use App\Http\Controllers\SearchApiController;
use App\Http\Controllers\InvoiceApiController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/login",[UserApiController::class, 'login']);
Route::post("/register",[UserApiController::class, 'register']);
Route::get("/profile",[UserApiController::class, 'profile']);
Route::get("/listuser",[UserApiController::class, 'index']);

Route::get("/same/{id}",[SearchApiController::class, 'sameproduct']);
Route::get("/find/{id}",[SearchApiController::class, 'find']);
Route::get("/findCaPro",[SearchApiController::class, 'findCategoryHasProduct']);

Route::apiResource("/category", CategoryApiController::class);
Route::apiResource("/supplier", SupplierApiController::class);
Route::apiResource("/product", ProductApiController::class);
Route::apiResource("/invoice", InvoiceApiController::class);
