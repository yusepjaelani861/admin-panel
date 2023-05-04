<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function list(Request $request)
    {
        if (!$this->protect()) {
            return redirect()->route('dashboard');
        }

        $users = User::with('role');

        if ($request->search) {
            $users = $users->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        if ($request->role) {
            $users = $users->where('role_id', (int) $request->role);
        }

        $users = $users->paginate((int) $request->limit ?? 10);

        $roles = Role::all();

        return view('admin.list', [
            'users' => $users,
            'roles' => $roles
        ]);
    }

    public function create()
    {
        if (!$this->protect()) {
            return redirect()->route('dashboard');
        }

        $roles = Role::all();

        return view('admin.create', [
            'roles' => $roles
        ]);
    }

    public function view(int $id)
    {
        if (!$this->protect()) {
            return redirect()->route('dashboard');
        }

        $user = User::with('role')->where('id', $id)->first();
        if (!$user) {
            return redirect()->route('admin.list')->with('error', 'User not found');
        }

        $roles = Role::all();

        return view('admin.view', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|integer|exists:roles,id'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.create')->with('error', $validator->errors()->first());
        }

        $cek = User::where('email', $request->email)->first();
        if ($cek) {
            return redirect()->route('admin.create')->with('error', 'Email already registered');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => (int) $request->role_id,
            'password' => Hash::make($request->password)
        ]);

        if (!$user) {
            return redirect()->route('admin.create')->with('error', 'Failed to create user');
        }

        return redirect()->route('admin.index')->with('success', 'User created successfully');
    }

    public function updateUser(int $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|email',
            'password' => 'nullable|string|min:8',
            'role_id' => 'required|integer|exists:roles,id'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.view', $id)->with('error', $validator->errors()->first());
        }

        if ($id === Auth::user()->id) {
            return redirect()->route('admin.view', $id)->with('error', 'You cannot edit your own account');
        }

        $user = User::where('id', $id)->first();
        if (!$user) {
            return redirect()->route('admin.index')->with('error', 'User not found');
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = (int) $request->role_id;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.view', $id)->with('success', 'User updated successfully');
    }
}
