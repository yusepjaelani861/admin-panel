<?php

namespace App\Http\Controllers;

use App\Models\CDN\Files;
use App\Models\CDN\Transaction;
use App\Models\CDN\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $role_user = Auth::user()->role_id === 1;
        $cache = Cache::get('dashboard');
        if ($cache) {
                return view($role_user ? 'viewers.index' : 'dashboard', $cache);
        }

        $total_files = Files::where([
            'status' => true,
        ])->count();
        $total_users = User::count();
        $total_usage = Files::where([
            'status' => true,
        ])->sum('size');
        $total_earning = Transaction::where('status', 'PAID')->sum('amount');

        Cache::put('dashboard', [
            'total_files' => $total_files,
            'total_users' => $total_users,
            'total_usage' => $total_usage,
            'total_earning' => $total_earning
        ], 60);

        return view($role_user ? 'viewers.index' : 'dashboard', [
            'total_files' => $total_files,
            'total_users' => $total_users,
            'total_usage' => $total_usage,
            'total_earning' => $total_earning
        ]);
    }
}
