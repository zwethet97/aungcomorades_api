<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TwoDController;
use App\Http\Controllers\ThreeDController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BetSlipController;
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

// Route::resource('twoDs', TwoDController::class);

// Route::resource('products', ProductController::class);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// Route::get('/products', [ProductController::class, 'index']);
// Route::get('/products/{id}', [ProductController::class, 'show']);
// Route::get('/products/search/{name}', [ProductController::class, 'search']);
Route::get('/dtwod', [TwoDController::class, 'index']);
Route::get('/dtwod/{date}', [TwoDController::class, 'show']);
Route::get('/dtwod/search/{name}', [TwoDController::class, 'search']);
Route::get('/dthree', [ThreeDController::class, 'index']);
Route::get('/dthree/{date}', [ThreeDController::class, 'show']);
Route::get('/dthree/search/{name}', [ThreeDController::class, 'search']);


// Route::get('/products', [ProductController::class, 'index']);
// Route::post('/products', [ProductController::class, 'store']);

//Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    // Route::post('/products', [ProductController::class, 'store']);
    // Route::put('/products/{id}', [ProductController::class, 'update']);
    // Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::post('/dtwod', [TwoDController::class, 'store']);
    Route::put('/dtwod/{id}', [TwoDController::class, 'update']);
    Route::delete('/dtwod/{id}', [TwoDController::class, 'destroy']);
    Route::post('/dthreed', [ThreeDController::class, 'store']);
    Route::put('/dthreed/{id}', [ThreeDController::class, 'update']);
    Route::delete('/dthreed/{id}', [ThreeDController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/normal-user', [UserAuthController::class, 'store']);
    Route::get('/transaction', [TransactionController::class, 'index']);
    Route::post('/deposit', [TransactionController::class, 'deposit']);
    Route::post('/withdraw', [TransactionController::class, 'withdraw']);
    Route::post('/transfer', [TransactionController::class, 'transfer']);
    Route::post('/paymentinfo', [PaymentController::class, 'store']);
    Route::post('/betslip', [BetslipController::class, 'store']);
    Route::get('/betslip', [BetslipController::class, 'index']);
    Route::post('/referral', [ReferralController::class, 'store']);
    Route::get('/referral', [ReferralController::class, 'index']);
    Route::get('/normal-user', [UserAuthController::class, 'index']);   

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
