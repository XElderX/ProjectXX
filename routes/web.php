<?php

use App\Http\Controllers\ClubController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TownController;
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
    Route::post('countries/edit/{id}', 'update')->middleware('auth')->name('countries.update');
    // Route::get('users/{uuid}', 'show')->middleware('auth')->name('users.show');
    // Route::get('users/ban/{uuid}', 'disable')->middleware('auth')->name('users.ban');
});

Route::controller(TownController::class)->group(function () {
    Route::get('towns', 'index')->middleware('auth')->name('towns');
    // Route::get('countries/add', 'create')->middleware('auth')->name('countries.add');
    Route::post('towns', 'store')->middleware('auth')->name('towns.store');
    Route::get('towns/{id}', 'destroy')->middleware('auth')->name('town.delete');
    Route::post('towns/edit/{id}', 'update')->middleware('auth')->name('towns.update');
    // Route::get('users/{uuid}', 'show')->middleware('auth')->name('users.show');
    // Route::get('users/ban/{uuid}', 'disable')->middleware('auth')->name('users.ban');
});

Route::controller(ClubController::class)->group(function () {
    Route::get('clubs', 'index')->middleware('auth')->name('clubs');
    // Route::get('countries/add', 'create')->middleware('auth')->name('countries.add');
    Route::post('clubs', 'store')->middleware('auth')->name('clubs.store');
    Route::get('clubs/{id}', 'destroy')->middleware('auth')->name('club.delete');
    Route::post('clubs/edit/{id}', 'update')->middleware('auth')->name('club.update');
    Route::post('clubs/dynamic', 'fetch')->middleware('auth')->name('club.fetch');
    // Route::get('users/{uuid}', 'show')->middleware('auth')->name('users.show');
    // Route::get('users/ban/{uuid}', 'disable')->middleware('auth')->name('users.ban');
});

Route::controller(PlayerController::class)->group(function () {
    Route::get('players', 'index')->middleware('auth')->name('players');
    // Route::get('countries/add', 'create')->middleware('auth')->name('countries.add');
    Route::post('players', 'store')->middleware('auth')->name('players.store');
    Route::get('players/{id}', 'destroy')->middleware('auth')->name('player.delete');
    Route::post('players/edit/{id}', 'update')->middleware('auth')->name('player.update');
    // Route::post('clubs/dynamic', 'fetch')->middleware('auth')->name('club.fetch');
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
