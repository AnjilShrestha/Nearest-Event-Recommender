<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\LoginController;
use App\Http\Controllers\EventOrganizerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\EventRecommender;
use Illuminate\Http\Request;

use Illuminate\Auth\Middleware\Authenticate;


Route::post('/', function(Request $request) {
    $validated = $request->validate([
        'lat' => 'required|numeric',
        'lng' => 'required|numeric'
    ]);
    
    // Store in session
    session([
        'user_location' => [
            'lat' => $validated['lat'],
            'lng' => $validated['lng']
        ]
    ]);
    
    if ($request->wantsJson()) {
        return response()->json(['success' => true]);
    }
    
    return redirect()->route('/', [
        'lat' => $validated['lat'],
        'lng' => $validated['lng']
    ]);
});

Route::view('/', 'welcome');
Route::get('/',[EventRecommender::class,'eventlist'])->name('/');

Route::group(['prefix'=>'/'],function(){


    Route::get('/login', function () {
        return view('users.login');
    })->name('user.login');
    Route::post('/login', [LoginController::class, 'userlogin'])->name('user.login.post');
    Route::get('/logout', [LoginController::class, 'userlogout'])->name('user.logout');
    Route::get('/register', function () {
        return view('users.register');
    })->name('user.register');
    Route::post('/register', [UserController::class, 'register'])->name('user.register.post');
    

});






Route::group(['prefix'=>'user','middleware'=>'auth:user'],function(){
    Route::get('/dashboard', [UserController::class,'upcomingevent'])->name('user.dashboard');
});

Route::get('/eventdetails/{id}',[EventRecommender::class,'details'])->name('event.details');

Route::post('/search',[EventRecommender::class,'eventsearch'])->name('search');
Route::group(['prefix'=>'/','middleware'=>'auth:user'],function(){

    Route::post('/esewa',[PaymentController::class,'paymentStart'])->name('pay.esewa');
    Route::get('/success', [PaymentController::class, 'verifyPayment'])->name('esewa.success');
    Route::get('/payment/esewa/failure', [PaymentController::class, 'paymentFailure'])->name('esewa.failure');

    Route::get('/tickets',[UserController::class,'tickets'])->name('user.ticket');
});

