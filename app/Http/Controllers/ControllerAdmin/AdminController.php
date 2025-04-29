<?php

namespace App\Http\Controllers\ControllerAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Admin;


class AdminController extends Controller
{
    //
    public function addAdmin(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admin,username',
            'email' => 'required|email|unique:admin,email',
            'password' => 'required|min:6',
        ]);


        $admin = new Admin();
        $admin->name = $request->input('name');
        $admin->username = $request->input('username');
        $admin->email = $request->input('email');
        $admin->password = bcrypt($request->input('password'));
        $admin->save();


        return redirect()->route('admin.adminlist')->with('success', 'Admin registered successfully.');
    }

    public function editAdmin($id)
    {
        $admin = Admin::findOrFail($id);

        return view('admins.editadmin', compact('admin'));
    }
    public function updateAdmin(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        if ($request->input('password') == null) {
            $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:admin,username,' . $id,
                'email' => 'required|email|unique:admin,email,' . $id,
            ]);
        } else {
            $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:admin,username,' . $id,
                'email' => 'required|email|unique:admin,email,' . $id,
                'password' => 'min:6',
            ]);
        }
        if ($request->input('password') != null) {
            $admin->password = bcrypt($request->input('password'));
        }
        $admin->name = $request->input('name');
        $admin->username = $request->input('username');
        $admin->email = $request->input('email');
        $admin->save();
        return redirect()->route('admin.adminlist')->with('success', 'Admin updated successfully.');
    }
    public function deleteAdmin($id)
    {

        $admin = Admin::findOrFail($id);

        $admin->delete();

        return redirect()->route('admin.adminlist')->with('success', 'Admin deleted successfully.');
    }
}
