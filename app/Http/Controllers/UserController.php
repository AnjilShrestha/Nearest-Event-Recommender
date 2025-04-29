<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use App\Models\TicketPurchased;


class UserController extends Controller
{
    //
    public function showLoginForm()
    {
        return view('users.login');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);
        

        $user=new User();
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();
        

        session()->flash('success', 'Registration successful. Please login.');

        return redirect()->route('user.login')->with('success', 'Registration successful. Please login.');

    }


    public function upcomingevent()
    {
        $events=TicketPurchased::with(['user','Event'])->paginate(2);
        return view('users.dashboard',compact('events'));   
    }
}
