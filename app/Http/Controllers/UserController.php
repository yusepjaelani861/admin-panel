<?php

namespace App\Http\Controllers;

use App\Models\CDN\Files;
use App\Models\CDN\Roles\Role;
use App\Models\CDN\Subscription;
use App\Models\CDN\Transaction;
use App\Models\CDN\User;
use App\Models\CDN\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function list(Request $request)
    {
        if (!$this->protect()) {
            return redirect()->route('dashboard');
        }

        $users = User::with('roles')
            ->orderBy('id', 'desc');

        if ($request->search) {
            $users = $users->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        if ($request->role) {
            // $users = $users->where('role_id', (int) $request->role);
            $users = $users->whereHas('roles', function ($query) use ($request) {
                $query->where('role_id', (int) $request->role);
            });
        }

        if ($request->expired) {
            $users = $users->orderBy('balance', 'asc');
        }

        $users = $users->paginate((int) $request->limit ?? 15);
        $users->appends($request->all());

        foreach ($users as $user) {
            $user->usage = Files::where('user_id', $user->id)->sum('size');
        }

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

        $user = User::where('id', $id)->with('roles')
            ->withCount('files', 'folders')
            ->first();

        if (!$user) {
            return redirect()->route('users.list')->with('error', 'User not found');
        }

        // $log = Subscription::where([
        //     'user_id' => $user->id,
        //     'role_id' => $user->role_id
        // ])
        //     ->where('end_date', '>=', now())
        //     ->orderBy('end_date', 'desc')
        //     ->first();

        // $user->log = $log;

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

        $user->size = Files::where('user_id', $user->id)->sum('size');

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

        DB::beginTransaction();

        try {
            //code...
            $role = Role::where('id', $request->role_id)->first();
            if (!$role) {
                return redirect()->back()->with('error', 'Role not found');
            }

            $user = User::where('id', $id)->first();
            if (!$user) {
                return redirect()->back()->with('error', 'User not found');
            }

            $userRoles = UserRole::where('user_id', $user->id)->orderBy('id', 'desc')->first();

            if ($userRoles) {
                $userRoles->role_id = $request->role_id;
                $userRoles->save();
            } else {
                UserRole::create([
                    'user_id' => $user->id,
                    'role_id' => $request->role_id,
                ]);
            }

            $user->role_id = $request->role_id;
            $user->balance = $user->balance + $role->price;
            $user->save();

            DB::commit();

            return redirect()->back()->with('success', 'User updated');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }

    }
}
