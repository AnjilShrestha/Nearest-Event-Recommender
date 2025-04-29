<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ControllerAdmin\AdminController;

use App\Http\Controllers\ControllerAdmin\AdminOrganizerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EventOrganizerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ControllerAdmin\AdminUserController;
use App\Http\Controllers\UserController;

use App\Models\EventOrganizer;

use Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\EventRecommender;
use Illuminate\Http\Request;

use Illuminate\Auth\Middleware\Authenticate;
 
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







