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
use App\Http\Controllers\NotiController;
use App\Http\Controllers\RewardController;

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
Route::post('/step2-reset', [UserAuthController::class, 'verifyOTPreset']);
Route::post('/final-reset', [UserAuthController::class, 'finalpwdreset']);
// Route::get('/products', [ProductController::class, 'index']);
// Route::get('/products/{id}', [ProductController::class, 'show']);
// Route::get('/products/search/{name}', [ProductController::class, 'search']);
Route::get('/2dbet-time-check', [TwoDController::class, 'checkTime']);
Route::get('/3dbet-time-check', [ThreeDController::class, 'checkTime']);
Route::get('/internetbet-time-check', [ThreeDController::class, 'checkInternetTime']);
Route::get('/plusbet-time-check', [TwoDController::class, 'checkPlusTime']);
Route::get('/dtwod', [TwoDController::class, 'index']);
Route::get('/thaiwantwod', [TwoDController::class, 'checkThaiwan']);
Route::get('/dtwod/{id}', [TwoDController::class, 'show']);
Route::get('/dtwod/search/{date}', [TwoDController::class, 'search']);
Route::get('/dthreed', [ThreeDController::class, 'index']);
Route::get('/closeday', [ThreeDController::class, 'getCloseDay']);
Route::get('/dthreed/current', [ThreeDController::class, 'weekResult']);
Route::get('/internet', [ThreeDController::class, 'indexInternet']);
Route::get('/dthreed/{year}/{weekno}', [ThreeDController::class, 'weeknumber']);
Route::get('/dthreed/{id}', [ThreeDController::class, 'show']);
Route::get('/version', [ThreeDController::class, 'getVersion']);
Route::get('/dthreed/search/date/{name}', [ThreeDController::class, 'search']);
Route::get('/thaithreed', [ThaiThreeDController::class, 'index']);
Route::get('/thaithreed/{id}', [ThaiThreeDController::class, 'show']);
Route::get('/thaithreed/search/{date}', [ThaiThreeDController::class, 'search']);
Route::get('/info', [BannerController::class, 'index']);
Route::post('/info', [BannerController::class, 'store']);
Route::get('/check', [BetCheckController::class, 'checkBet']);
Route::get('/betdetail/{id}', [BetSlipController::class, 'betDetail']);
Route::get('/tips', [TipsController::class, 'index']);
Route::post('/profit/auth', [BetSlipController::class, 'authCom']);
Route::get('/profit/data/', [BetSlipController::class, 'indexTwoD']);
Route::post('/profit/data/bet', [BetSlipController::class, 'viewBet']);
Route::get('/threedprofit/data/', [BetSlipController::class, 'indexThreeD']);
Route::post('/threedprofit/data/bet', [BetSlipController::class, 'viewThreeDBet']);
Route::get('/plustwodprofit/data/', [BetSlipController::class, 'indexPlusTwoD']);
Route::post('/plustwodprofit/data/bet', [BetSlipController::class, 'viewPlusTwoDBet']);
Route::get('/internetprofit/data/', [BetSlipController::class, 'indexInternet']);
Route::post('/internetprofit/data/bet', [BetSlipController::class, 'viewInternetBet']);
Route::get('/twod/profile/{id}', [TipsController::class, 'searchTwoDTodayTips']);
Route::get('/soccer/todaytips/{id}', [TipsController::class, 'searchSoccerTodayTips']);
Route::get('/soccer-tipshistory/{id}', [TipsController::class, 'searchSoccerTipsHistory']);
Route::get('/twod-tipshistory/{id}', [TipsController::class, 'searchTipsHistory']);
Route::get('/tipbanner', [TipsController::class, 'showBanner']);









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
    Route::get('/check/role/{id}', [UserAuthController::class, 'checkRole']);
    //Route::post('/normal-user', [UserAuthController::class, 'store']);
    Route::get('/transaction', [TransactionController::class, 'index']);
    Route::get('/transaction/search/{userid}', [TransactionController::class, 'search']);
    Route::get('/transfer/{phone}', [TransactionController::class, 'searchtransferUserPhone']);
    Route::post('/deposit', [TransactionController::class, 'deposit']);
    Route::post('/withdraw', [TransactionController::class, 'withdraw']);
    Route::post('/transfer', [TransactionController::class, 'transfer']);
    Route::post('/paymentinfo', [PaymentController::class, 'store']);
    Route::get('/paymentinfo/{id}', [PaymentController::class, 'show']);
    Route::delete('/paymentinfo/delete/{id}', [PaymentController::class, 'destroy']);
    Route::get('/paymentinfo/search/{name}', [PaymentController::class, 'search']);
    Route::post('/betslip', [BetSlipController::class, 'store']);
    Route::post('/limit/check', [BetSlipController::class, 'checkBet']);
    Route::post('/limit/d3d/check', [BetSlipController::class, 'check3dBet']);
    Route::post('/limit/internet/check', [BetSlipController::class, 'checkInternetBet']);
    Route::post('/limit/d2dplus/check', [BetSlipController::class, 'check2dplusBet']);
    Route::get('/betslip', [BetSlipController::class, 'index']);
    Route::get('/betslip/search/{userid}', [BetSlipController::class, 'search']);
    Route::post('/referral', [ReferralController::class, 'store']);
    Route::get('/referral/check/{submitid}', [ReferralController::class, 'check_submit']);
    Route::get('/referral', [ReferralController::class, 'index']);
    Route::get('/referral/list/{code}', [ReferralController::class, 'show']);
    Route::get('/reward/list/{id}', [RewardController::class, 'show']);
    Route::get('/referral/search/{name}', [ReferralController::class, 'search']);
    Route::get('/normal-user', [UserAuthController::class, 'index']);
    Route::get('/normal-user/show/{id}', [UserAuthController::class, 'show']);
    Route::get('/normal-user/search/referral/{name}', [UserAuthController::class, 'searchReferral']);
    Route::get('/normal-user/search/{name}', [UserAuthController::class, 'searchPhone']);   
    Route::post('/profile/{id}', [UserAuthController::class, 'update']);
    Route::post('/update/password/{id}', [UserAuthController::class, 'updatePassword']);
    Route::post('/update/phone/{id}', [UserAuthController::class, 'updatePhone']);
    Route::post('/updatedstep2/phone/{id}', [UserAuthController::class, 'updatePhone2']);
    Route::post('/upgrade/{id}', [TransactionController::class, 'upgrade']);
    Route::get('/adminpayment', [PaymentController::class, 'adminPayment']);
    Route::get('/noti/user/{id}',[NotiController::class,'showbyUserId']);
    Route::get('/submit/check/{id}',[ReferralController::class,'checkSubmit']);


});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
