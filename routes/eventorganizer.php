<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\LoginController;
use App\Http\Controllers\EventOrganizerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Models\EventCategory;


use Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\EventRecommender;
use Illuminate\Http\Request;

use Illuminate\Auth\Middleware\Authenticate;





// login for event organizer and user
Route::group(['prefix'=>'/'],function(){

    Route::get('/eventorganizer/login', function () {
        return view('eventorganizer.login');
    })->name('eventorganizer.login');
    Route::post('/eventorganizer/login', [LoginController::class, 'organizerlogin'])->name('eventorganizer.login.post');
    Route::get('/eventorganizer/logout', [LoginController::class, 'organizerlogout'])->name('eventorganizer.logout');
});





Route::group(['prefix'=>'eventorganizer'],function(){
    Route::get('register', function () {
        return view('eventorganizer.register');
    })->name('eventorganizer.register');
    Route::post('register', [EventOrganizerController::class, 'register'])->name('eventorganizer.register.post');
    Route::get('/dashboard',function(){
        return view('eventorganizer.dashboard');
    })->name('eventorganizer.dashboard');
});


Route::group(['prefix'=>'eventorganizer','middleware'=>'auth:eventorganizer'],function(){
    Route::get('/addevent',function(){
        $categories=EventCategory::paginate();
        return view('eventorganizer.addevent',compact('categories'));
    })->name('eventorganizer.addevent');

    Route::get('/events',[EventController::class,'eventlist'])->name('eventorganizer.events');

    Route::post('/events/addevent',[EventController::class,'store'])->name('eventorganizer.addevent.post');

    Route::get('/{id}/edit', [EventController::class,'eventdetails'])->name('eventorganizer.event.edit');

    Route::put('/{id}/update',[EventController::class, 'updateEvent'])->name('eventorganizer.event.update');

    Route::delete('/{id}/delete',[EventController::class,'deleteEvent'])->name('eventorganizer.event.delete');
});

