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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/home',[App\Http\Controllers\HomeController::class,'viewBet'])->name('bet.view');

// Route::get('/home', [App\Http\Controllers\UserAuthController::class, 'index']);

Route::prefix('admin')->group(function(){
     Route::resource('/users',App\Http\Controllers\Admin\UserController::class);
    //  Route::resource('/transaction',App\Http\Controllers\Admin\TransactionController::class);
     Route::get('/users/betslip/{id}',[App\Http\Controllers\Admin\UserController::class,'showUserBetslip'])->name('users.betslip');
     Route::get('/users/transaction/{id}',[App\Http\Controllers\Admin\UserController::class,'showUserTransaction'])->name('users.transaction');
     Route::get('/users/referral/{name}',[App\Http\Controllers\Admin\UserController::class,'showUserReferral'])->name('users.referral');
     Route::get('/transaction/deposit',[App\Http\Controllers\Admin\TransactionController::class,'deposit'])->name('transaction.deposit');
     Route::post('/transaction/deposit/update/{id}',[App\Http\Controllers\Admin\TransactionController::class,'depoUpdate'])->name('transaction.deposit.update');
     Route::get('/transaction/withdraw',[App\Http\Controllers\Admin\TransactionController::class,'withdraw'])->name('transaction.withdraw');
     Route::post('/transaction/withdraw/update/{id}',[App\Http\Controllers\Admin\TransactionController::class,'withdrawUpdate'])->name('transaction.withdraw.update');
     Route::resource('/betslips',App\Http\Controllers\Admin\BetSlipController::class);
     Route::get('/compensate',[App\Http\Controllers\Admin\CompensateController::class,'index'])->name('compensate.index');
     Route::get('/compensate/round',[App\Http\Controllers\Admin\CompensateController::class,'roundIndex'])->name('compensate.round');
     Route::post('/compensate/threed',[App\Http\Controllers\Admin\CompensateController::class,'compensateThreed'])->name('compensate.threed');
     Route::post('/compensate/threed/round',[App\Http\Controllers\Admin\CompensateController::class,'roundCompensate'])->name('compensate.threed.round');
     Route::get('/compensate/twodview',[App\Http\Controllers\Admin\CompensateController::class,'twodindex'])->name('compensate.twodview');
     Route::post('/compensate/twod',[App\Http\Controllers\Admin\CompensateController::class,'compensateTwod'])->name('compensate.twod');
     Route::resource('/tips',App\Http\Controllers\Admin\TipController::class);
     Route::post('/tips',[App\Http\Controllers\Admin\TipController::class,'createTipProfile'])->name('tips.create');
     Route::post('/tips/daily',[App\Http\Controllers\Admin\TipController::class,'createTodayTip'])->name('tips.daily.create');
     Route::post('/tips/record',[App\Http\Controllers\Admin\TipController::class,'createRecordTip'])->name('tips.record.create');
     Route::get('/tips/daily/{id}',[App\Http\Controllers\Admin\TipController::class,'showToday'])->name('tips.daily');
     Route::get('/tips/record/{id}',[App\Http\Controllers\Admin\TipController::class,'showRecord'])->name('tips.record');
     Route::resource('/reward',App\Http\Controllers\Admin\ReferralController::class);
     Route::resource('/reward/threed',App\Http\Controllers\Admin\ThreedReferralController::class);
     Route::resource('/payment',App\Http\Controllers\Admin\AdminPaymentController::class);
     Route::resource('/intro',App\Http\Controllers\Admin\IntroBannerController::class);
     Route::resource('/tipbanner',App\Http\Controllers\Admin\TipBannerController::class);
     Route::post('/payment/create',[App\Http\Controllers\Admin\ReferralController::class,'create'])->name('payment.create');
     Route::post('/reward',[App\Http\Controllers\Admin\ReferralController::class,'submit'])->name('reward.twod.submit');
     Route::post('/reward/threed',[App\Http\Controllers\Admin\ThreedReferralController::class,'submit'])->name('reward.threed.submit');

});

