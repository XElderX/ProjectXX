<?php

use App\Http\Controllers\CountryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Webpatser\Uuid\Uuid;

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
Route::get('uuid-gen', function () {

    dd(Uuid::generate()->string);

});

Route::get('/', function () {
    return view('welcome');
});

Route::controller(UserController::class)->group(function () {
    Route::get('users', 'index')->middleware('auth')->name('users');
    Route::get('users/{uuid}', 'show')->middleware('auth')->name('users.show');
    Route::get('users/ban/{uuid}', 'disable')->middleware('auth')->name('users.ban');
});

Route::controller(CountryController::class)->group(function () {
    Route::get('countries', 'index')->middleware('auth')->name('national');
    Route::get('countries/add', 'create')->middleware('auth')->name('countries.add');
    Route::post('countries', 'store')->middleware('auth')->name('countries.store');
    Route::get('countries/{id}', 'destroy')->middleware('auth')->name('countries.delete');
    Route::post('countries/edit/{id}', 'update')->middleware('auth')->name('countries.update');;
    // Route::get('users/{uuid}', 'show')->middleware('auth')->name('users.show');
    // Route::get('users/ban/{uuid}', 'disable')->middleware('auth')->name('users.ban');
});

// Route::get('users', function() {
//     return view('users.index');

// })->name('users');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
