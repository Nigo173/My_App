<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\LabelController;

use App\Http\Middleware\AdminsMiddleware;
// use App\Http\Middleware\LogMiddleware;
use App\Http\Middleware\AuthMiddleware;

Route::prefix('/')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('user_login');
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware(AdminsMiddleware::class)
    ->prefix('member')
    ->group(function()
    {
    Route::get('/', [MemberController::class, 'index'])->name('member');
    Route::any('list', [MemberController::class, 'list'])->name('member_list');
    Route::any('create', [MemberController::class, 'create'])->name('member_create');
    Route::any('update', [MemberController::class, 'update'])->name('member_update');
    Route::any('delete', [MemberController::class, 'delete'])->name('member_delete');
});

Route::middleware(AdminsMiddleware::class)
    ->prefix('trade')
    ->group(function()
    {
    Route::get('/', [TradeController::class, 'index'])->name('trade');
    Route::any('list', [TradeController::class, 'list'])->name('trade_list');
    Route::any('create', [TradeController::class, 'create'])->name('trade_create');
});

Route::prefix('dashboard')
    ->group(function()
    {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('update', [DashboardController::class, 'update'])->name('trade_update');
});

Route::middleware(AdminsMiddleware::class)
    ->prefix('settings')
    ->group(function()
    {

    Route::get('/', [SettingsController::class, 'index'])->name('settings');

    Route::prefix('admins')->group(function () {
        Route::get('/', [AdminsController::class, 'index'])->name('admins');
        Route::any('list', [AdminsController::class, 'list'])->name('admins_list');
        Route::any('create', [AdminsController::class, 'create'])->name('admins_create');
        Route::any('update', [AdminsController::class, 'update'])->name('admins_update');
        Route::any('delete', [AdminsController::class, 'delete'])->name('admins_delete');
    });

    Route::prefix('log')->group(function () {
        Route::any('/', [LogController::class, 'index'])->name('log');
    });

    Route::prefix('label')->group(function () {
        Route::any('/', [LabelController::class, 'index'])->name('label');
        Route::post('create', [LabelController::class, 'create'])->name('label_create');
        Route::post('update', [LabelController::class, 'update'])->name('label_update');
    });
});

Route::fallback(function(){
    return \Response::view('error');
});
