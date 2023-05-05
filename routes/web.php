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
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'list'])->name('admin.index');
        Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
        Route::post('/create', [AdminController::class, 'createUser']);
        Route::get('/{id}', [AdminController::class, 'view'])->name('admin.view');
        Route::post('/{id}/update', [AdminController::class, 'updateUser'])->name('admin.update');
        Route::delete('/{id}', [AdminController::class, 'deleteUser'])->name('admin.delete');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'list'])->name('users.index');
        Route::get('/{id}', [UserController::class, 'view'])->name('users.view');
        Route::post('/{id}/update', [UserController::class, 'updateProfile'])->name('users.update');
        Route::post('/{id}/roles', [UserController::class, 'updateRole'])->name('users.roles');
    });

    Route::prefix('files')->group(function () {
        Route::get('/', [FilesController::class, 'list'])->name('files.index');
        Route::post('/backup', [FilesController::class, 'backupStorage'])->name('files.backup');
        Route::post('/user/empty', [FilesController::class, 'emptyStorage'])->name('files.empty.user');
        Route::delete('/{id}', [FilesController::class, 'delete'])->name('files.delete');
    });

    Route::prefix('transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'list'])->name('transactions.index');
    });

    Route::prefix('/subscription')->group(function () {
        Route::get('/', [SubscriptionController::class, 'listSubscription'])->name('subscriptions.index');
        Route::get('/create', [SubscriptionController::class, 'createSubscriptionPage'])->name('subscriptions.create');
        Route::get('/{id}', [SubscriptionController::class, 'viewSubscription'])->name('subscriptions.view');
        Route::post('/create', [SubscriptionController::class, 'createSubscription']);
        Route::post('/{id}/update', [SubscriptionController::class, 'updateSubscription'])->name('subscriptions.update');
        Route::delete('/{id}', [SubscriptionController::class, 'deleteSubscription'])->name('subscriptions.delete');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
