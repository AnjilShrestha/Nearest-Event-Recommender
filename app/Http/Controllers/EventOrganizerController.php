<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventOrganizer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EventOrganizerController extends Controller
{
    //
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:event_organizer,email',
            'password' => 'required|string|min:6|confirmed',
            'username' => 'required|string|unique:event_organizer,username',
            'company_name' => 'required|string',
            'company_website' => 'required|url',
            'company_phone' => 'required|string',
            'company_address' => 'required|string',
            'company_description' => 'required|string',
            'company_logo' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
    
        if ($request->hasFile('company_logo')) {
            $logoPath = $request->file('company_logo')->store('logos','public');
            $validated['company_logo'] = $logoPath;
        }
    
            $event_organizer = EventOrganizer::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'username' => $validated['username'],
                'company_name' => $validated['company_name'],
                'company_website' => $validated['company_website'],
                'company_phone' => $validated['company_phone'],
                'company_address' => $validated['company_address'],
                'company_description' => $validated['company_description'],
                'company_logo' => $validated['company_logo'],
            ]);
    
            return redirect()->route('eventorganizer.login')
                   ->with('success', 'Registration successful!');
    
    }

}
