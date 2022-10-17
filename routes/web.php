<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix(LaravelLocalization::setLocale())->middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    })->name('home');
    Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // start setting routes
        Route::name('settings.')->prefix('settings')->group(function () {
            Route::post('', [SettingController::class, 'update'])->name('update');
            Route::get('general', [SettingController::class, 'general'])->name('general');
        });
        // end setting routes

        // start invoices routes
        Route::post('invoices' , [InvoiceController::class , 'store'])->name('invoices.store');
        // end invoices routes

        // start resources routes
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::resource('plans', PlanController::class);
        Route::resource('clients', ClientController::class);
        Route::resource('subscriptions', SubscriptionController::class);
        // end resources routes

    });


    require __DIR__ . '/auth.php';
});
