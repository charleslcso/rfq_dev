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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('welcome');
})->name('home');

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

/*
 * You can use:
 *
 * Route::group(['middleware' => ''], Closure);
 *
 * or
 *
 * Route::middleware([''])->group(Closure);
 *
 * But you cannot place additional parameters for Route::group([]) into ->group()! Not the same!
 */
//Route::group(['middleware' => 'auth'], function() {
//	Route::group(['middleware' => 'role:client', 'prefix' => 'client', 'as' => 'client.'], function () {
//		Route::resource('rfq', \App\Http\Controllers\Clients\RFQController::class);
//	});
//	Route::group(['middleware' => 'role:vendor', 'prefix' => 'vendor', 'as' => 'vendor.'], function () {
//		Route::resource('rfq', \App\Http\Controllers\Vendors\RFQReplyController::class);
//	});
//	Route::group(['middleware' => 'role:admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
//		Route::resource('rfq', \App\Http\Controllers\Admin\RFQAdminController::class);
//	});
//});

Route::middleware(['auth'])->group(function() {					// CS
	Route::group(['middleware' => 'role:client', 'prefix' => 'client', 'as' => 'client.'], function () {
		Route::resource('rfq', \App\Http\Controllers\Clients\RFQController::class);
		Route::resource('apply-rfq', \App\Http\Controllers\Clients\ApplyRFQController::class); // JY | CS
		Route::resource('handle-jotform-submission', \App\Http\Controllers\Clients\HandleJotformSubmissionController::class); // JY
		// Route::get('pay-rfq', [\App\Http\Controllers\Clients\StripeController::class, 'stripe']);
		// Route::get('apply-rfq', \App\Http\Controllers\Clients\ApplyRFQController::class);
		// Route::post('stripe', [\App\Http\Controllers\Clients\StripeController::class, 'stripePost'])->name('stripe.post');
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