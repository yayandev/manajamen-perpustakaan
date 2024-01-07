<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $users = User::where('name', 'like', '%' . $request->search . '%')->paginate(5);
            return view('users.index', compact('users'));
        }

        $users = User::paginate(5);
        return view('users.index', compact('users'));
    }

    public function userProfile()
    {
        return view('userprofile');
    }

    public function changeProfile(Request $request)
    {
        $request->validate([
            'file' => 'image|mimes:png,jpg,jpeg|max:2048',
            'name' => 'required|max:255|min:3|required',
        ]);

        $user = User::find(auth()->user()->id);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $file->storeAs('public/users', $file->hashName());

            $oldImage = $user->profile_picture;

            $user->profile_picture = $file->hashName();
            $user->name = $request->name;
            $user->save();

            if (basename($oldImage) !== 'default.png') {
                Storage::delete('public/users/' . basename($oldImage));
            }
        } else {
            $user->name = $request->name;
            $user->save();
        }

        return redirect('/userprofile')->with(['success' => 'Profile Picture Changed']);
    }


    public function changePassword(Request $request)
    {
        $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|same:newPassword',
        ]);


        $user = User::find(auth()->user()->id);

        if (!Hash::check($request->oldPassword, $user->password)) {
            return redirect('/userprofile')->with(['error' => 'Incorrect Old Password']);
        }

        $user->password = bcrypt($request->newPassword);

        $user->save();

        return redirect('/userprofile')->with(['success' => 'Password Changed']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|min:3|required',
            'email' => 'required|email|unique:users',
            'level' => 'required|in:admin,user',
        ]);

        $pass = substr($request->email, 0, strpos($request->email, '@'));

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($pass),
            'level' => $request->level,
        ]);

        if (!$user) {
            return redirect('/users')->with(['error' => 'User Creation Failed']);
        }

        return redirect('/users')->with(['success' => 'User Created Successfully password default: ' . $pass]);
    }

    public function resetPassword($id)
    {

        $user = User::find($id);
        if (!$user) {
            return redirect('/users')->with(['error' => 'User Not Found']);
        }
        $pass = substr($user->email, 0, strpos($user->email, '@'));
        $user->password = bcrypt($pass);
        $user->save();
        return redirect('/users')->with(['success' => 'User Password Reset Successfully password default: ' . $pass]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'max:255|min:3',
            'email' => 'email|unique:users,email,' . $id,
            'level' => 'in:admin,user',
        ]);

        $user = User::find($id);

        if (!$user) {
            return redirect('/users')->with(['error' => 'User Not Found']);
        }

        $user->update($request->all());

        return redirect('/users')->with(['success' => 'User Updated Successfully']);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect('/users')->with(['error' => 'User Not Found']);
        }

        if (basename($user->profile_picture) !== 'default.png') {
            Storage::delete('public/users/' . basename($user->profile_picture));
        }
        $user->delete();
        return redirect('/users')->with(['success' => 'User Deleted Successfully']);
    }
}
