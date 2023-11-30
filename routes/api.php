<?php

use App\Models\pharmacist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MedcineController;
use App\Http\Controllers\PharmacistController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register',[PharmacistController::class,'register']);
Route::post('login',[PharmacistController::class,'login']);
Route::post('webLogin',[PharmacistController::class,'webLogin']);
Route::apiResource('medcines', MedcineController::class);
// Route::middleware('auth:sanctum')->group(function(){
// });
Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('orders', OrderController::class);
});
Route::get('viewOrders',[OrderController::class,'viewAllOrders']);
Route::patch('orderStatus/{orderId}',[OrderController::class,'updateStatus']);
Route::patch('billingStatus/{orderId}',[OrderController::class,'updateBillingStatus']);
Route::post('addToFavorites/{medcineId}',[MedcineController::class,'addToFavorites']);
