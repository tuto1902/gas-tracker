<?php

use App\Livewire\CreateFuelEntry;
use App\Livewire\CreateVehicle;
use App\Livewire\Dashboard;
use App\Livewire\FuelEntries;
use App\Livewire\EditFuelEntry;
use App\Livewire\EditVehicle;
use App\Livewire\Vehicles;
use Illuminate\Support\Facades\Route;
use Laravel\WorkOS\Http\Middleware\ValidateSessionWithWorkOS;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/vehicles', Vehicles::class)->middleware('auth')->name('vehicles.index');
Route::get('/vehicles/create', CreateVehicle::class)->middleware('auth')->name('vehicles.create');
Route::get('/vehicles/{vehicle}/edit', EditVehicle::class)->middleware('auth')->name('vehicles.edit');

Route::get('/fuel-entries/{vehicle?}', FuelEntries::class)->middleware('auth')->name('fuel-entries.index');
Route::get('/fuel-entries/{vehicle}/create', CreateFuelEntry::class)->middleware('auth')->name('fuel-entries.create');
Route::get('/fuel-entries/{vehicle}/{fuelEntry}/edit', EditFuelEntry::class)->middleware('auth')->name('fuel-entries.edit');

Route::middleware([
    'auth',
    ValidateSessionWithWorkOS::class,
])->group(function () {
    // Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('dashboard', Dashboard::class)->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
