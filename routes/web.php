<?php

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
Route::get('users', function() {
    return 'users';

});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
