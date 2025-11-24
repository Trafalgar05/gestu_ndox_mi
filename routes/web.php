<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminController; 

Route::get('/', function () {
    return view('welcome');
});

Route::get('/signaler', [ReportController::class, 'create'])->name('reports.create');
Route::post('/signaler', [ReportController::class, 'store'])->name('reports.store');

Route::get('/admin/login', [AdminController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');

Route::middleware('auth')->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::post('/admin/reports/{report}/status', [AdminController::class, 'updateStatus'])->name('admin.reports.status');
    Route::delete('/admin/reports/{report}', [AdminController::class, 'destroy'])->name('admin.reports.destroy');
    Route::post('/admin/update-address', [AdminController::class, 'updateAddress'])->name('admin.reports.update-address');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/subscription/initialize', [SubscriptionController::class, 'initializePayment'])
         ->name('subscription.initialize');
    Route::get('/subscription/callback', [SubscriptionController::class, 'handleCallback'])
         ->name('subscription.callback');
});

Route::middleware(['auth', 'premium'])->group(function () {
    Route::get('/premium/reports/pdf', [PremiumFeatureController::class, 'generatePDF'])
         ->name('premium.reports.pdf');
    Route::get('/premium/reports/analyze', [PremiumFeatureController::class, 'analyzeData'])
         ->name('premium.reports.analyze');
});

