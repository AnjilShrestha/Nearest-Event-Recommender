<?php

namespace App\Http\Controllers\ControllerAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventOrganizer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;

class AdminOrganizerController extends Controller
{
    //
    public function list()
    {
        $event_organizers = EventOrganizer::where('status','pending')->Paginate(10);
        return view('admins.neworganizer', compact('event_organizers'));
    }
    public function show($id)
    {
        $event_organizer = EventOrganizer::findOrFail($id);
        return view('admins.eventorganizerlist', compact('event_organizer'));
    }

    public function organizerapprove($id)
    {
        $event_organizer = EventOrganizer::findOrFail($id);
        $event_organizer->status='approved';
        $event_organizer->save();
        return redirect()->back()->with("Success","Organizer approved successfully");
    }
    public function organizerreject($id)
    {
        $event_organizer = EventOrganizer::findOrFail($id);
        $event_organizer->status='rejected';
        $event_organizer->save();
        return redirect()->back()->with("Success","Organizer rejected successfully");
    }

    public function edit($id)
    {
        $event_organizer = EventOrganizer::findOrFail($id);
        return view('admins.eventorganizerlist', compact('event_organizer'));
    }

    public function deleteOrganizer($id)
    {
        $event_organizer = EventOrganizer::findOrFail($id);

        $admin->delete();


        return redirect()->back()->with('success', 'Organizer deleted successfully.');
    }
    public function update(Request $request, $id)
    {
        $event_organizer = EventOrganizer::findOrFail($id);
        // Validate the request data
        if ($request->input('password') == null) {
            $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:event_organizer,username,' . $id,
                'email' => 'required|email|unique:event_organizer,email,' . $id,
            ]);
        } else {
            $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:event_organizer,username,' . $id,
                'email' => 'required|email|unique:event_organizer,email,' . $id,
                'password' => 'nullable|min:6',
            ]);
        }
        // Update the event organizer details
        if ($request->input('password') != null) {
            $event_organizer->password = Hash::make($request->input('password'));
        }
        $event_organizer->name = $request->input('name');
        $event_organizer->username = $request->input('username');
        $event_organizer->email = $request->input('email');
        $event_organizer->save();

        // Redirect to the event organizer list page with a success message
        return redirect()->route('admin.eventorganizerlist')->with('success', 'Event Organizer updated successfully.');
    }
}
