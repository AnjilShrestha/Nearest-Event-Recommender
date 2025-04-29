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

        $today = now()->toDateString();
        $eventPurchases = TicketPurchased::where('user_id', auth()->id())
        ->with('event')
        ->get()
        ->groupBy('event_id');

        $upcomingEvents = $eventPurchases->filter(function ($purchases) use ($today) {
            return optional($purchases->first()->event)->event_date > $today;
        });

        $endedEvents = $eventPurchases->filter(function ($purchases) use ($today) {
            return optional($purchases->first()->event)->event_date <= $today;
        });
        $upcomingCount = $upcomingEvents->count();
        $endedCount = $endedEvents->count();
        return view('users.dashboard',[
            'upcomingEvents' => $upcomingEvents,
            'endedEvents' => $endedEvents,
            'upcomingCount' => $upcomingCount,
            'endedCount' => $endedCount,
        ]);   
    }

    public function tickets()
    {
        $tickets=TicketPurchased::where('user_id', auth()->id())
        ->orderBy('desc')
        ->paginate(5);

        return view('users.ticket',compact('tickets'));
    }
}
