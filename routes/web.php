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

Route::get('/', ['App\Http\Controllers\CityController', 'index'])->name('index');

Route::get('/cities/{id}', ['App\Http\Controllers\CityController', 'show'])
     ->where('id', '[0-9]+')
     ->name('cities.show');

//Dashboard routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', ['App\Http\Controllers\CityController', 'adminIndex'])->name('dashboard');

    //City CRUD routes
    Route::get('/dashboard/create', ['App\Http\Controllers\CityController', 'create'])
         ->name('dashboard.cities.create');

    Route::post('/dashboard', ['App\Http\Controllers\CityController', 'store'])
         ->name('dashboard.cities.store');

    Route::get('/dashboard/edit', ['App\Http\Controllers\CityController', 'edit'])
         ->name('dashboard.cities.edit');

    Route::put('/dashboard', ['App\Http\Controllers\CityController', 'update'])
         ->name('dashboard.cities.update');

    Route::delete('/dashboard/destroy', ['App\Http\Controllers\CityController', 'destroy'])
         ->name('dashboard.cities.destroy');
});

require __DIR__ . '/auth.php';
