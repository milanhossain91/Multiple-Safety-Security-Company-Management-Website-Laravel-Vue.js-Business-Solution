<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $user   = new User();
        $action = url('/admin/users');

        return view('admin.users.create', compact('user', 'action'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/admin/users')->with('success', 'User created.');
    }

    public function edit($id)
    {
        $user   = User::findOrFail($id);
        $action = url('/admin/users/' . $user->id);

        return view('admin.users.edit', compact('user', 'action'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect('/admin/users')->with('success', 'User updated.');
    }

    public function destroy($id)
    {
        if (Auth::id() == $id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        User::findOrFail($id)->delete();

        return redirect('/admin/users')->with('success', 'User deleted.');
    }
}
