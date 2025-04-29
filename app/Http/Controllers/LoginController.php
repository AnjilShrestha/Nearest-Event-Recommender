<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\EventOrganizer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    //
    public function adminlogin(Request $request)
    {
        // Validate the request data
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to log in the admin
        if (Auth::guard('admin')->attempt($request->only('username', 'password'))) {
            return redirect()->route('admin.adminlist')->with('success', 'Login successful.');
        }
        // If login fails, redirect back with an error message
        return redirect()->back()->withErrors(['error' => 'Invalid credentials.']);
    }

    public function adminlogout()
    {
        // Log out the admin
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }

    public function organizerlogin(Request $request)
    {
        // Validate the request data
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $username=$request['username'];
        $password=$request['password'];
        // Attempt to log in the event organizer
        if (Auth::guard('eventorganizer')->attempt(['username'=>$username,'password'=>$password,'status'=>'approved'])) {
            return redirect()->route('eventorganizer.dashboard')->with('success', 'Login successful.');
        }else{
            // If login fails, redirect back with an error message
            return redirect()->back()->withErrors(['error' => 'Invalid credentials.']);
        }
    }
    public function organizerlogout()
    {
        // Log out the event organizer
        Auth::guard('eventorganizer')->logout();
        return redirect()->route('eventorganizer.login')->with('success', 'Logged out successfully.');
    }
    public function userlogin(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to log in the user
        if (Auth::guard('user')->attempt($request->only('email', 'password'))) {
            return redirect()->route('/')->with('success', 'Login successful.');
        }
        // If login fails, redirect back with an error message
        return redirect()->back()->withErrors(['error' => 'Invalid credentials.']);
    }
    public function userlogout()
    {
        // Log out the user
        Auth::guard('user')->logout();
        return redirect()->route('user.login')->with('success', 'Logged out successfully.');
    }
}
