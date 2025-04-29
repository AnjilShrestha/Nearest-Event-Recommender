<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ControllerAdmin\AdminController;

use App\Http\Controllers\ControllerAdmin\AdminOrganizerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EventOrganizerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ControllerAdmin\AdminUserController;
use App\Http\Controllers\UserController;


use App\Http\Controllers\PaymentController;

use App\Models\Admin;
use App\Models\User;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventOrganizer;

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

//route admin details
Route::group(['prefix'=>'admin'], function(){
    Route::get('/addadmin', function () {
        return view('admins.addadmin');
    })->name('admin.addadmin');
    Route::post('/addadmin', [AdminController::class, 'addAdmin'])->name('admin.addadmin.post');

    Route::get('/adminlist', function () {
        $admins = Admin::simplePaginate(10);
        return view('admins.adminlist', compact('admins'));
    })->name('admin.adminlist');

    Route::get('/editadmin/{id}', [AdminController::class, 'editAdmin'])->name('admin.editadmin');
    Route::post('/updateadmin/{id}', [AdminController::class, 'updateAdmin'])->name('admin.updateadmin');
    Route::post('/{id}/delete', [AdminController::class, 'deleteAdmin'])->name('admin.deleteadmin');
});

// login for admin, event organizer and user
Route::group(['prefix'=>'/'],function(){
    Route::get('/admin/login', function () {
        return view('admins.login');
    })->name('admin.login');
    Route::post('/admin/login', [LoginController::class, 'adminlogin'])->name('admin.login.post');
    Route::get('/adminlogout', [LoginController::class, 'adminlogout'])->name('admin.logout');

    Route::get('/eventorganizer/login', function () {
        return view('eventorganizer.login');
    })->name('eventorganizer.login');
    Route::post('/eventorganizer/login', [LoginController::class, 'organizerlogin'])->name('eventorganizer.login.post');
    Route::get('/eventorganizer/logout', [LoginController::class, 'organizerlogout'])->name('eventorganizer.logout');

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


Route::group(['prefix'=>'admin/dashboard'],function(){
    Route::get('/', function () {
        return view('admins.dashboard');
    })->name('admin.dashboard')->middleware('auth:admin');
});

//route for admin viewing & managing event organizers
Route::group(['prefix'=>'admin/eventorganizer','middleware'=>'auth:admin'],function(){
    Route::get('/', function () {
        $event_organizers = EventOrganizer::where('status','approved')->paginate(10);
        return view('admins.eventorganizerlist', compact('event_organizers'));
    })->name('admin.eventorganizerlist');
    Route::get('/{id}/edit', function () {
        return view('admins.eventorganizerlist');
    })->name('admin.eventorganizer.edit');

    Route::get('/status',[AdminOrganizerController::class,'list'])->name('admin.eventorganizer.status');
    Route::get('/{id}/delete',[AdminOrganizerController::class,'deleteOrganizer'])->name('admin.eventorganizer.delete');
    Route::get('/{id}/approve',[AdminOrganizerController::class,'organizerapprove']
    )->name('admin.eventorganizer.approve');
    Route::get('/{id}/reject',[AdminOrganizerController::class,'organizerreject']
    )->name('admin.eventorganizer.reject');
    Route::get('/{id}/view', function () {
        return view('admins.eventorganizerlist');
    })->name('admin.eventorganizer.view');
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


//admin event categories control
Route::group(['prefix'=>'admin','middleware'=>'auth:admin'],function(){

    Route::get('/eventcategories',[EventController::class, 'eventCategories'])->name('admin.eventcategories');
    Route::post('/eventcategories', [EventController::class, 'storeEventCategory'])->name('admin.eventcategories.post');
    Route::get('/eventcategories/{id}/edit', [EventController::class, 'editEventCategory'])->name('admin.eventcategories.edit');
    Route::put('eventcategories/{id}', [EventController::class, 'update'])->name('admin.eventcategories.update');

    Route::post('/eventcategories/{id}/update', [EventController::class, 'updateEventCategory'])->name('admin.eventcategories.update');
    Route::post('/eventcategories/{id}/delete', [EventController::class, 'deleteEventCategory'])->name('admin.eventcategories.delete');
});


//admin user control
Route::group(['prefix'=>'admin/users','middleware'=>'auth:admin'],function(){
    Route::get('/', function () {
        $users =User::paginate(10);
        return view('admins.userlist', compact('users'));
    })->name('admin.userlist');
    Route::get('/{id}/edit', function () {
        return view('admins.userlist');
    })->name('admin.userlist.edit');
    Route::put('/{id}/update',[AdminUserController::class, 'updateUser'])->name('admin.user.update');
    Route::delete('/{id}/delete', [AdminUserController::class, 'deleteUser'])->name('admin.users.delete');
});


Route::group(['prefix'=>'user','middleware'=>'auth:user'],function(){
    Route::get('/dashboard', [UserController::class,'upcomingevent'])->name('user.dashboard');
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


Route::group(['prefix'=>'/'],function(){
    Route::get('/eventdetails/{id}',[EventRecommender::class,'details'])->name('event.details');

    Route::post('/search',[EventRecommender::class,'eventsearch'])->name('search');

    Route::post('/esewa',[PaymentController::class,'paymentStart'])->name('pay.esewa');
    Route::get('/success', [PaymentController::class, 'verifyPayment'])->name('esewa.success');
Route::get('/payment/esewa/failure', [PaymentController::class, 'paymentFailure'])->name('esewa.failure');
});

