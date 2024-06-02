<?php

use App\Http\Controllers\ClubController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\FriendlyInvitationController;
use App\Http\Controllers\GeneratorController;
use App\Http\Controllers\MatchScheduleController;
use App\Http\Controllers\NameSurnameController;
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
    Route::get('users/myAccount', 'info')->middleware('auth')->name('users.info');
    Route::get('users/{uuid}', 'show')->middleware('auth')->name('users.show');
    Route::get('users/ban/{uuid}', 'disable')->middleware('auth')->name('users.ban');
    Route::post('users/myAccount/{id}', 'infoUpdate')->middleware('auth')->name('user.update');
});

Route::controller(CountryController::class)->group(function () {
    Route::get('countries', 'index')->middleware('auth')->name('national');
    Route::get('countries/add', 'create')->middleware('auth')->name('countries.add');
    Route::post('countries', 'store')->middleware('auth')->name('countries.store');
    Route::get('countries/{id}', 'destroy')->middleware('auth')->name('countries.delete');
    Route::post('countries/edit/{id}', 'update')->middleware('auth')->name('countries.update');
});

Route::controller(TownController::class)->group(function () {
    Route::get('towns', 'index')->middleware('auth')->name('towns');
    Route::post('towns', 'store')->middleware('auth')->name('towns.store');
    Route::get('towns/{id}', 'destroy')->middleware('auth')->name('town.delete');
    Route::post('towns/edit/{id}', 'update')->middleware('auth')->name('towns.update');
});

Route::controller(ClubController::class)->group(function () {
    Route::get('clubs', 'index')->middleware('auth')->name('clubs');
    Route::post('clubs', 'store')->middleware('auth')->name('clubs.store');
    Route::get('clubs/{id}', 'destroy')->middleware('auth')->name('club.delete');
    Route::post('clubs/edit/{id}', 'update')->middleware('auth')->name('club.update');
    Route::post('clubs/dynamic', 'fetch')->middleware('auth')->name('club.fetch');
    Route::get('generated-team/{id}', 'show')->middleware('auth')->name('genTeam');
});

Route::controller(PlayerController::class)->group(function () {
    Route::get('players', 'index')->middleware('auth')->name('players');
    Route::post('players', 'store')->middleware('auth')->name('players.store');
    Route::get('players/{id}', 'destroy')->middleware('auth')->name('player.delete');
    Route::get('players/clear/{value}', 'clear')->middleware('auth')->name('player.clear');
    Route::post('players/edit/{id}', 'update')->middleware('auth')->name('player.update');
    Route::get('generated-player/{id}', 'show')->middleware('auth')->name('genPlayer');
    Route::get('club/{id}/players', 'teamPlayersList')->middleware('auth')->name('teamPlayers');
    Route::get('club/players/{id}', 'fire')->middleware('auth')->name('player.fire');
});

Route::controller(NameSurnameController::class)->group(function () {
    Route::get('name-surname', 'index')->middleware('auth')->name('nameSurname');
    Route::post('store-name', 'storeName')->middleware('auth')->name('names.store');
    Route::post('store-surname', 'storeSurname')->middleware('auth')->name('surnames.store');
    Route::get('delete-name/{id}', 'destroyName')->middleware('auth')->name('name.delete');
    Route::get('delete-surname/{id}', 'destroySurname')->middleware('auth')->name('surname.delete');
    Route::post('name/edit/{id}', 'updateName')->middleware('auth')->name('name.update');
    Route::post('surname/edit/{id}', 'updateSurname')->middleware('auth')->name('surname.update');
});
Route::controller(GeneratorController::class)->group(function () {
    Route::get('generator', 'index')->middleware('auth')->name('generator');
    Route::post('player-generator', 'generatePlayer')->middleware('auth')->name('playerGenerator');
    Route::post('team-generator', 'generateTeam')->middleware('auth')->name('teamGenerator');
    Route::get('get-towns/{id}', 'getTowns')->name('getTownz');
});

Route::controller(MatchScheduleController::class)->group(function () {
    Route::get('propose-friendly', 'proposeFriendlyView')->middleware('auth')->name('friendlyView');
    Route::get('fixtures', 'scheduledMatches')->middleware('auth')->name('schedules');
    Route::get('{id}/match-details', 'matchDetails')->middleware('auth')->name('matchReport');
    Route::get('{id}/matchForm', 'matchForm')->middleware('auth')->name('matchOrders');
    Route::post('{id}submit-lineup', 'lineup')->middleware('auth')->name('postLineup');
});

Route::controller(FriendlyInvitationController::class)->group(function () {
    Route::post('propose-friendly', 'proposeFriendly')->middleware('auth')->name('proposeFriendly');
    Route::get('friendly-invitations', 'friendlyInvitations')->middleware('auth')->name('friendlyInvitations');
    Route::get('{id}/proposial-action/{action}', 'proposialAction')->middleware('auth')->name('proposialAction');
    Route::post('host-friendly', 'proposialAction')->middleware('auth')->name('hostFriendly');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';
