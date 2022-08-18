<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/logout', function () {
    return view('welcome');
});

Route::get('/privacy', function () {
    return view('privacy');
});

Route::prefix('controlcenter')->group(function () {
    Auth::routes();
    Route::get('/logout', function () {
    return view('welcome');
});
    
});


// Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class,'logout']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/betdetail/threed', [App\Http\Controllers\HomeController::class, 'indexThreeD'])->name('betdetail.twodplus');
Route::get('/betdetail/twodplus', [App\Http\Controllers\HomeController::class, 'indexTwodPlus'])->name('betdetail.twodplus');
Route::get('/betdetail/internet', [App\Http\Controllers\HomeController::class, 'indexInternet'])->name('betdetail.internet');
Route::post('/home',[App\Http\Controllers\HomeController::class,'viewBet'])->name('bet.view');
Route::post('/home/threed',[App\Http\Controllers\HomeController::class,'viewThreeDBet'])->name('bet.threed');
Route::post('/home/twodplus',[App\Http\Controllers\HomeController::class,'viewPlusBet'])->name('bet.twodplus');
Route::post('/home/internet',[App\Http\Controllers\HomeController::class,'viewInternetBet'])->name('bet.internet');



// Route::get('/home', [App\Http\Controllers\UserAuthController::class, 'index']);

Route::prefix('admin')->group(function(){
     Route::resource('/users',App\Http\Controllers\Admin\UserController::class);
    //  Route::resource('/transaction',App\Http\Controllers\Admin\TransactionController::class);
     Route::get('/users/betslip/{id}',[App\Http\Controllers\Admin\UserController::class,'showUserBetslip'])->name('users.betslip');
     Route::get('/users/transaction/{id}',[App\Http\Controllers\Admin\UserController::class,'showUserTransaction'])->name('users.transaction');
     Route::get('/users/referral/{name}',[App\Http\Controllers\Admin\UserController::class,'showUserReferral'])->name('users.referral');
     Route::post('/users/deposit/{id}',[App\Http\Controllers\Admin\UserController::class,'depoUpdate'])->name('users.deposit.update');
     Route::post('/users/withdraw/{id}',[App\Http\Controllers\Admin\UserController::class,'withdrawUpdate'])->name('users.withdraw.update');
     Route::get('/transaction/deposit',[App\Http\Controllers\Admin\TransactionController::class,'deposit'])->name('transaction.deposit');
     Route::delete('/transaction/record/delete/{id}',[App\Http\Controllers\Admin\TransactionController::class,'delete'])->name('transaction.record.delete');
     Route::post('/transaction/deposit/update/{id}',[App\Http\Controllers\Admin\TransactionController::class,'depoUpdate'])->name('transaction.deposit.update');
     Route::get('/transaction/withdraw',[App\Http\Controllers\Admin\TransactionController::class,'withdraw'])->name('transaction.withdraw');
     Route::post('/transaction/withdraw/update/{id}',[App\Http\Controllers\Admin\TransactionController::class,'withdrawUpdate'])->name('transaction.withdraw.update');
     Route::resource('/betslips',App\Http\Controllers\Admin\BetSlipController::class);
     Route::put('/compensate/noon',[App\Http\Controllers\Admin\CompensateController::class,'noonSlipChange'])->name('compensate.noon');
     Route::put('/compensate/even',[App\Http\Controllers\Admin\CompensateController::class,'evenSlipChange'])->name('compensate.even');
     
     Route::get('/compensate',[App\Http\Controllers\Admin\CompensateController::class,'index'])->name('compensate.index');
     Route::get('/compensate/round',[App\Http\Controllers\Admin\CompensateController::class,'roundIndex'])->name('compensate.round');
     Route::post('/compensate/threed',[App\Http\Controllers\Admin\CompensateController::class,'compensateThreed'])->name('compensate.threed');
     Route::post('/compensate/threed/round',[App\Http\Controllers\Admin\CompensateController::class,'roundCompensate'])->name('compensate.threed.round');
     Route::get('/compensate/twodview',[App\Http\Controllers\Admin\CompensateController::class,'twodindex'])->name('compensate.twodview');
     Route::get('/compensate/internet',[App\Http\Controllers\Admin\CompensateController::class,'internetIndex'])->name('compensate.internet');
     Route::get('/compensate/plusview',[App\Http\Controllers\Admin\CompensateController::class,'plusTwodIndex'])->name('compensate.plusview');
     Route::get('/compensate/number',[App\Http\Controllers\Admin\CompensateController::class,'winNumber'])->name('compensate.number');
     Route::post('/compensate/number/{id}',[App\Http\Controllers\Admin\CompensateController::class,'winUpdate'])->name('compensate.number.update');
     Route::post('/compensate/internet/number/{id}',[App\Http\Controllers\Admin\CompensateController::class,'winInternetUpdate'])->name('compensate.internet.update');
     Route::post('/compensate/limit/{id}',[App\Http\Controllers\Admin\CompensateController::class,'limitUpdate'])->name('compensate.limit.update');
     Route::post('/compensate/twod',[App\Http\Controllers\Admin\CompensateController::class,'compensateTwod'])->name('compensate.twod');
     Route::post('/compensate/internet',[App\Http\Controllers\Admin\CompensateController::class,'compensateInternet'])->name('compensate.internet');
     Route::post('/compensate/twodplus',[App\Http\Controllers\Admin\CompensateController::class,'compensatePlusTwod'])->name('compensate.twodplus');
     Route::resource('/tips',App\Http\Controllers\Admin\TipController::class);
     Route::post('/tips',[App\Http\Controllers\Admin\TipController::class,'createTipProfile'])->name('tips.create');
     Route::post('/tips/daily',[App\Http\Controllers\Admin\TipController::class,'createTodayTip'])->name('tips.daily.create');
     Route::post('/tips/record',[App\Http\Controllers\Admin\TipController::class,'createRecordTip'])->name('tips.record.create');
     Route::get('/tips/daily/{id}',[App\Http\Controllers\Admin\TipController::class,'showToday'])->name('tips.daily');
     Route::get('/tips/record/{id}',[App\Http\Controllers\Admin\TipController::class,'showRecord'])->name('tips.record');
     Route::get('/reward',[App\Http\Controllers\Admin\TwodReferralController::class,'index'])->name('reward.index');
     Route::resource('/reward/threed',App\Http\Controllers\Admin\ThreedReferralController::class);
     Route::resource('/payment',App\Http\Controllers\Admin\AdminPaymentController::class);
     Route::resource('/intro',App\Http\Controllers\Admin\IntroBannerController::class);
     Route::resource('/tipbanner',App\Http\Controllers\Admin\TipBannerController::class);
    //  Route::post('/payment/create',[App\Http\Controllers\Admin\ReferralController::class,'create'])->name('payment.create');
     Route::post('/reward',[App\Http\Controllers\Admin\TwodReferralController::class,'submit'])->name('reward.twod.submit');
     Route::post('/reward/threed',[App\Http\Controllers\Admin\ThreedReferralController::class,'submit'])->name('reward.threed.submit');

});

