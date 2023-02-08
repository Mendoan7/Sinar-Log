<?php

use Illuminate\Support\Facades\Route;

// frontsite
use App\Http\Controllers\Frontsite\LandingController;

// backsite
use App\Http\Controllers\Backsite\DashboardController;
use App\Http\Controllers\Backsite\PermissionController;
use App\Http\Controllers\Backsite\RoleController;
use App\Http\Controllers\Backsite\UserController;
use App\Http\Controllers\Backsite\TypeUserController;
use App\Http\Controllers\Backsite\CustomerController;
use App\Http\Controllers\Backsite\ServiceController;
use App\Http\Controllers\Backsite\ServiceDetailController;
use App\Http\Controllers\Backsite\TransactionController;

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

Route::resource('/', LandingController::class);

// backsite
Route::group(['prefix' => 'backsite', 'as' => 'backsite.', 'middleware' => ['auth:sanctum', 'verified']], function () {

    // dashboard
    Route::resource('dashboard', DashboardController::class);

    // permission
    Route::resource('permission', PermissionController::class);

    // role
    Route::resource('role', RoleController::class);

    // user
    Route::resource('user', UserController::class);

    // type user
    Route::resource('type_user', TypeUserController::class);

    // customer
    Route::resource('customer', CustomerController::class);

    // service
    Route::resource('service', ServiceController::class);

    // service detail
    Route::resource('service-detail', ServiceDetailController::class);

    // transaction
    Route::resource('transaction', TransactionController::class);

});

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });

