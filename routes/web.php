<?php

use App\Livewire\CreateVehicle;
use App\Livewire\EditVehicle;
use Illuminate\Support\Facades\Route;
use Laravel\WorkOS\Http\Middleware\ValidateSessionWithWorkOS;
use App\Livewire\Vehicles;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/vehicles', Vehicles::class)->middleware('auth')->name('vehicles.index');
Route::get('/vehicles/create', CreateVehicle::class)->middleware('auth')->name('vehicles.create');
Route::get('/vehicles/{vehicle}/edit', EditVehicle::class)->middleware('auth')->name('vehicles.edit');

Route::middleware([
    'auth',
    ValidateSessionWithWorkOS::class,
])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
