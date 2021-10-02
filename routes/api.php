<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TwoDController;
use App\Http\Controllers\ThreeDController;
use App\Http\Controllers\ThaiThreeDController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BetSlipController;
use App\Http\Controllers\BetCheckController;
use App\Http\Controllers\BannerInfoController;
use App\Http\Controllers\TipsController;
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

Route::post('/register', [UserAuthController::class, 'register']);
Route::post('/verify', [UserAuthController::class, 'verifyOTP']);
Route::post('/login', [UserAuthController::class, 'login']);
Route::post('/reset', [UserAuthController::class, 'resetPassword']);
Route::post('/final-reset', [UserAuthController::class, 'verifyOTPreset']);
// Route::get('/products', [ProductController::class, 'index']);
// Route::get('/products/{id}', [ProductController::class, 'show']);
// Route::get('/products/search/{name}', [ProductController::class, 'search']);
Route::get('/bet-time-check', [TwoDController::class, 'checkTime']);
Route::get('/dtwod', [TwoDController::class, 'index']);
Route::get('/dtwod/{id}', [TwoDController::class, 'show']);
Route::get('/dtwod/search/{date}', [TwoDController::class, 'search']);
Route::get('/dthreed', [ThreeDController::class, 'index']);
Route::get('/dthreed/{id}', [ThreeDController::class, 'show']);
Route::get('/dthreed/search/{date}', [ThreeDController::class, 'search']);
Route::get('/thaithreed', [ThaiThreeDController::class, 'index']);
Route::get('/thaithreed/{id}', [ThaiThreeDController::class, 'show']);
Route::get('/thaithreed/search/{date}', [ThaiThreeDController::class, 'search']);
Route::get('/info', [BannerController::class, 'index']);
Route::post('/info', [BannerController::class, 'store']);
Route::get('/check', [BetCheckController::class, 'checkBet']);
Route::get('/betdetail/{id}', [BetSlipController::class, 'betDetail']);
Route::get('/tips', [TipsController::class, 'index']);
Route::get('/twod/todaytips/{id}', [TipsController::class, 'searchTwoDTodayTips']);
Route::get('/soccer/todaytips/{id}', [TipsController::class, 'searchSoccerTodayTips']);
Route::get('/soccer-tipshistory/{id}', [TipsController::class, 'searchSoccerTipsHistory']);
Route::get('/twod-tipshistory/{id}', [TipsController::class, 'searchTipsHistory']);








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
    Route::post('/thaithreed', [ThaiThreeDController::class, 'store']);
    Route::put('/thaithreed/{id}', [ThaiThreeDController::class, 'update']);
    Route::delete('/thaithreed/{id}', [ThaiThreeDController::class, 'destroy']);
    Route::post('/logout', [UserAuthController::class, 'logout']);
    //Route::post('/normal-user', [UserAuthController::class, 'store']);
    Route::get('/transaction', [TransactionController::class, 'index']);
    Route::get('/transaction/search/{userid}', [TransactionController::class, 'search']);
    Route::get('/transfer/{phone}', [TransactionController::class, 'searchtransferUserPhone']);
    Route::post('/deposit', [TransactionController::class, 'deposit']);
    Route::post('/withdraw', [TransactionController::class, 'withdraw']);
    Route::post('/transfer', [TransactionController::class, 'transfer']);
    Route::post('/paymentinfo', [PaymentController::class, 'store']);
    Route::get('/paymentinfo/search/{name}', [PaymentController::class, 'search']);
    Route::post('/betslip', [BetslipController::class, 'store']);
    Route::get('/betslip', [BetslipController::class, 'index']);
    Route::get('/betslip/search/{userid}', [BetslipController::class, 'index']);
    Route::post('/referral', [ReferralController::class, 'store']);
    Route::get('/referral', [ReferralController::class, 'index']);
    Route::get('/normal-user', [UserAuthController::class, 'index']);
    Route::get('/normal-user/search/{referral}', [UserAuthController::class, 'searchReferral']);
    Route::get('/normal-user/{phone}', [UserAuthController::class, 'searchPhone']);   
    Route::post('/profile/{id}', [UserAuthController::class, 'update']);

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
