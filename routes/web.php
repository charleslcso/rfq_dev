<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

/*
* original code
*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
/*
* end original
*/

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['middleware' => 'auth'], function() {
	Route::group(['middleware' => 'role:client', 'prefix' => 'client', 'as' => 'client.'], function () {
		Route::resource('rfq', \App\Http\Controllers\Clients\RFQController::class);
		Route::resource('apply-rfq', \App\Http\Controllers\Clients\ApplyRFQController::class);
		Route::resource('handle-jotform-submission', \App\Http\Controllers\Clients\HandleJotformSubmissionController::class);
	});
	Route::group(['middleware' => 'role:vendor', 'prefix' => 'vendor', 'as' => 'vendor.'], function () {
		Route::resource('list-all-rfqs', \App\Http\Controllers\Vendors\ListAllRFQsController::class);
		Route::resource('pend-quotations', \App\Http\Controllers\Vendors\PendQuotationsController::class);
		Route::resource('submitted-quotations', \App\Http\Controllers\Vendors\SubmittedQuotationsController::class);
	});
	Route::group(['middleware' => 'role:admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
		Route::resource('rfq', \App\Http\Controllers\Admin\RFQAdminController::class);
	});
});



