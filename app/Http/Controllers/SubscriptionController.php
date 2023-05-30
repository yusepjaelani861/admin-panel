<?php

namespace App\Http\Controllers;

use App\Models\CDN\Files;
use App\Models\CDN\Roles\Role;
use App\Models\CDN\Subscription;
use App\Models\CDN\SubscriptionLog;
use App\Models\CDN\Transaction;
use App\Models\CDN\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    public function listSubscription(Request $request)
    {
        if (!$this->protect()) {
            return redirect()->route('dashboard');
        }
        
        if ($request->has('search')) {
            $roles = Role::where('name', 'like', '%' . $request->search . '%')
                ->get();
        } else {
            $roles = Role::all();
        }

        return view('subscriptions.list', [
            'roles' => $roles,
        ]);
    }

    public function createSubscriptionPage()
    {
        if (!$this->protect()) {
            return redirect()->route('dashboard');
        }
        
        return view('subscriptions.create');
    }

    public function viewSubscription(int $id)
    {
        if (!$this->protect()) {
            return redirect()->route('dashboard');
        }
        
        $role = Role::where('id', $id)->first();
        if (!$role) {
            return redirect()->route('subscriptions.index')->with('error', 'Role not found');
        }

        $total_subscribe = Subscription::where('role_id', $role->id)->count();
        $logs = SubscriptionLog::where('name', $role->name)->with('transaction');
        $total_earning = 0;
        foreach ($logs->get() as $log) {
            $total_earning += $log->transaction->amount;
        }
        $users = User::where('role_id', $role->id);
        $roleActive = $users->count();

        $users = $users->with('role')->paginate(10);

        foreach ($users as $user) {
            $log = Subscription::where([
                'user_id' => $user->id,
            ])
                ->orderBy('end_date', 'desc')
                ->first();

            $usage = Files::where([
                'user_id' => $user->id,
                'status' => true,
            ])->sum('size');

            $user->log = $log;
            $user->usage = $usage;
        }

        return view('subscriptions.view', [
            'role' => $role,
            'total_subscribed' => $total_subscribe,
            'total_earning' => $total_earning,
            'user_active' => $roleActive,
            'users' => $users,
        ]);
    }

    public function createSubscription(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'price' => 'required|numeric',
            'max_storage' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $role = Role::create([
            'name' => $request->name,
            'price' => $request->price,
            'max_storage' => $request->max_storage,
        ]);

        return redirect()->route('subscriptions.index')->with('success', 'Role created successfully');
    }

    public function updateSubscription(int $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'price' => 'required|numeric',
            'max_storage' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $role = Role::where('id', $id)->first();
        if (!$role) {
            return redirect()->route('subscriptions.index')->with('error', 'Role not found');
        }

        $role->name = $request->name;
        $role->price = $request->price;
        $role->max_storage = $request->max_storage;
        $role->save();

        return redirect()->route('subscriptions.view', [
            'id' => $role->id,
        ])->with('success', 'Role updated successfully');
    }

    public function deleteSubscription(int $id)
    {
        $role = Role::where('id', $id)->first();
        if (!$role) {
            return redirect()->route('subscriptions.index')->with('error', 'Role not found');
        }

        $users = User::where('role_id', $role->id)->get();
        foreach ($users as $user) {
            $user->role_id = 1;
            $user->save();
        }

        $role->delete();

        return redirect()->route('subscriptions.index')->with('success', 'Role deleted successfully');
    }
}
