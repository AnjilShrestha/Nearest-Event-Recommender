<?php

namespace App\Http\Controllers\ControllerAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;

use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller
{
    //
    public function showAdminUserList()
    {
        $users = User::simplePaginate(10);
        return view('admins.userlist', compact('users'));
    }
    // public function showAdminUserEdit($id)
    // {
    //     $user = User::findOrFail($id);
    //     return view('admins.edituser', compact('user'));
    // }
    public function updateUser(Request $request, $id)
    {
        //pasword
        if($request->input('password') !== null){
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'username' => 'required|unique:users,username,' . $id,
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'required|min:6|confirmed',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('show_edit_modal', $id);
            }
        }else{
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'username' => 'required|unique:users,username,' . $id,
                'email' => 'required|email|unique:users,email,' . $id,
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('show_edit_modal', $id);
            }
        }
        // Validate the request data
        $validated = $validator->validated();

        $user = User::findOrFail($id);
        if ($request->input('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->name = $validated['name'];
        $user->username = $validated['username'];
        $user->email = $validated['email'];
        $user->save();

        session()->flash('success', 'User updated successfully.');
        return redirect()->route('admin.userlist')->with('success', 'User updated successfully.');
    }
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        session()->flash('success', 'User deleted successfully.');
        return redirect()->route('admin.userlist')->with('success', 'User deleted successfully.');
    }
}
