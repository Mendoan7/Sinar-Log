<?php

use Illuminate\Support\Facades\Route;

// frontsite
use App\Http\Controllers\Frontsite\LandingController;
use App\Http\Controllers\Frontsite\TrackingController;

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
use App\Http\Controllers\Backsite\ReportTransactionController;
use App\Http\Controllers\Backsite\ReportEmployeesController;
use App\Http\Controllers\Backsite\NotificationController;

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

Route::get('tracking', [TrackingController::class, 'index']);
Route::post('tracking', [TrackingController::class, 'track']);
Route::get('tracking/service/{id}', [TrackingController::class, 'show'])->name('tracking.show');


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
    Route::post('service/confirmation/', [ServiceController::class, 'sendConfirmation']);
    Route::resource('service', ServiceController::class);

    Route::post('service/add-technician', [ServiceController::class, 'addTechnician'])->name('service.addTechnician');

    // service detail
    Route::post('service-detail/notification/', [ServiceDetailController::class, 'sendNotification']);
    Route::resource('service-detail', ServiceDetailController::class);
    Route::post('service-detail/warranty/', [ServiceDetailController::class, 'warranty'])->name('service-detail.warranty');

    // transaction
    Route::post('transaction/notification/', [TransactionController::class, 'sendNotification']);
    Route::resource('transaction', TransactionController::class);
    Route::post('transaction/warranty', [TransactionController::class, 'claimWarranty'])->name('transaction.claimWarranty');
    Route::post('transaction/warranty-done/', [TransactionController::class, 'warranty'])->name('transaction.warranty');

    // report
    Route::resource('report-transaction', ReportTransactionController::class);
    Route::resource('report-employees', ReportEmployeesController::class);
    Route::get('report-employees/{teknisiId}', [ReportEmployeesController::class, 'show'])->name('report-employees.show');
    Route::get('report-employees/teknisi/{teknisiId}/detail/{tanggal}', [ReportEmployeesController::class, 'detailReport'])->name('report-employees.detail');



    // notification
    Route::resource('notification', NotificationController::class);
    Route::get('notification/warranty/{id}', [NotificationController::class, 'warranty'])->name('notification.warranty');

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

