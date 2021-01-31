<?php

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FilesProductController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\Location\CityController;
use App\Http\Controllers\Location\DistrictController;
use App\Http\Controllers\Location\ProvinceController;
use App\Http\Controllers\Location\VillageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Models\CategoryProduct;
use App\Models\Transaction;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api', 'cors'], function () {
    Route::get('show/user/{id}', [AuthController::class, 'show']);
    Route::delete('delete/user/{id}', [AuthController::class, 'destroy']);
    Route::patch('update/user/{id}', [AuthController::class, 'update']);
    Route::resource('client', ClientController::class);
});

Route::resource('product', ProductController::class);
Route::resource('auction', AuctionController::class);
Route::resource('category/product', CategoryProductController::class);
Route::resource('files/product', FilesProductController::class);
Route::resource('history', HistoryController::class);
Route::resource('transaction', TransactionController::class);

Route::post('signup', [AuthController::class, 'signup']);
Route::post('signin', [AuthController::class, 'signin']);
Route::post('upload/user/{id}', [AuthController::class, 'upload']);
Route::get('verify/user/{id}', [AuthController::class, 'verify']);

Route::get('province/location', [ProvinceController::class, 'index']);
Route::get('province/{id}/location/', [ProvinceController::class, 'show']);
Route::get('city/location', [CityController::class, 'index']);
Route::get('city/{id}/location/', [CityController::class, 'show']);
Route::get('district/location', [DistrictController::class, 'index']);
Route::get('district/{id}/location/', [DistrictController::class, 'show']);
Route::get('village/location', [VillageController::class, 'index']);
Route::get('village/{id}/location/', [VillageController::class, 'show']);
