<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin', [AdminController::class, 'list'])->name('admin.index');
    Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin/create', [AdminController::class, 'createUser']);
    Route::get('/admin/{id}', [AdminController::class, 'view'])->name('admin.view');
    Route::post('/admin/{id}/update', [AdminController::class, 'updateUser'])->name('admin.update');
    Route::get('/users', [UserController::class, 'list'])->name('users.index');
    Route::get('/users/{id}', [UserController::class, 'view'])->name('users.view');
    Route::post('/users/{id}/update', [UserController::class, 'updateProfile'])->name('users.update');
    Route::post('/users/{id}/roles', [UserController::class, 'updateRole'])->name('users.roles');
    Route::get('/files', [FilesController::class, 'list'])->name('files.index');
    Route::post('/files/user/empty', [FilesController::class, 'emptyStorage'])->name('files.empty.user');
    Route::delete('/files/{id}', [FilesController::class, 'delete'])->name('files.delete');
    Route::get('/transactions', [TransactionController::class, 'list'])->name('transactions.index');
    Route::get('/subscription', [SubscriptionController::class, 'listSubscription'])->name('subscriptions.index');
    Route::get('/subscription/create', [SubscriptionController::class, 'createSubscriptionPage'])->name('subscriptions.create');
    Route::get('/subscription/{id}', [SubscriptionController::class, 'viewSubscription'])->name('subscriptions.view');
    Route::post('/subscription/create', [SubscriptionController::class, 'createSubscription']);
    Route::post('/subscription/{id}/update', [SubscriptionController::class, 'updateSubscription'])->name('subscriptions.update');
    Route::delete('/subscription/{id}', [SubscriptionController::class, 'deleteSubscription'])->name('subscriptions.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
