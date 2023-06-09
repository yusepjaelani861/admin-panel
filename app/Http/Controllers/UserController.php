<?php

namespace App\Http\Controllers;

use App\Models\CDN\Files;
use App\Models\CDN\Roles\Role;
use App\Models\CDN\Subscription;
use App\Models\CDN\Transaction;
use App\Models\CDN\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function list(Request $request)
    {
        if (!$this->protect()) {
            return redirect()->route('dashboard');
        }

        $users = User::with('role')
            ->orderBy('id', 'desc');

        if ($request->search) {
            $users = $users->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        if ($request->role) {
            $users = $users->where('role_id', (int) $request->role);
        }

        if ($request->expired) {
            $users = $users->whereHas('subscription', function ($query) {
                $query->where('end_date', '<=', now())
                    ->orWhere('end_date', '<=', now()->subDays(28));
            });
        }

        $users = $users->paginate((int) $request->limit ?? 15);

        foreach ($users as $user) {
            $log = Subscription::where([
                'user_id' => $user->id,
            ])
                ->orderBy('end_date', 'desc')
                ->first();

            $usage = Files::where([
                'user_id' => $user->id,
            ])->sum('size');

            $user->log = $log;
            $user->usage = $usage;
        }

        $users->appends($request->all());
        $roles = Role::all();

        return view('users.list', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    public function view(int $id, Request $request)
    {
        if (!$this->protect()) {
            return redirect()->route('dashboard');
        }
        
        $user = User::where('id', $id)->with('role', 'files', 'folders')->first();

        if (!$user) {
            return redirect()->route('users.list')->with('error', 'User not found');
        }

        $log = Subscription::where([
            'user_id' => $user->id,
            'role_id' => $user->role_id
        ])
            ->where('end_date', '>=', now())
            ->orderBy('end_date', 'desc')
            ->first();

        $user->log = $log;

        $transactions = Transaction::where([
            'user_id' => $user->id,
        ])->whereIn('status', ['PAID', 'UNPAID'])
        ->orderBy('id', 'desc')
        ->paginate((int) $request->limit ?? 15);

        $files = Files::where([
            'user_id' => $user->id,
        ])->with('folders')
        ->orderBy('id', 'desc')
        ->paginate((int) $request->limit ?? 15);

        $roles = Role::all();

        // return response()->json($session);

        return view('users.view', [
            'user' => $user,
            'transactions' => $transactions,
            'files' => $files,
            'roles' => $roles,
        ]);
    }

    public function updateProfile(int $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|email|max:255|min:3',
            'password' => 'nullable|string|max:255|min:3',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->errors()->first());
        }

        $user = User::where('id', $id)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->back()->with('success', 'User updated');
    }

    public function updateRole(int $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->errors()->first());
        }

        $role = Role::where('id', $request->role_id)->first();
        if (!$role) {
            return redirect()->back()->with('error', 'Role not found');
        }

        $user = User::where('id', $id)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        $user->role_id = $request->role_id;
        $user->save();

        return redirect()->back()->with('success', 'User updated');
    }
}
