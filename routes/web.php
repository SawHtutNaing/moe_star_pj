<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Dashboard;
use App\Livewire\UserManagement;
use Illuminate\Support\Facades\Route;
use App\Livewire\UserForm;
   use App\Livewire\Cars;
   use App\Livewire\CarGates;
   use App\Livewire\Drivers;
   use App\Livewire\Roles;

use App\Livewire\Trips;
use App\Livewire\OfferThings;
use App\Livewire\PassengerList;
use App\Livewire\Settings;

use App\Livewire\PassengerTypes;



Route::middleware(['auth',  'verified'])->group(function () {
        Route::get('/', Dashboard::class)->name('dashboard');

    Route::get('users', UserManagement::class)->name('users.index');
    Route::get('users/create', UserForm::class)->name('users.create');
    Route::get('users/{userId}/edit', UserForm::class)->name('users.edit');


Route::middleware('admin')->group(function () {
    Route::get('/cars', Cars::class)->name('cars');
    Route::get('/car-gates', CarGates::class)->name('car-gates');
    Route::get('/drivers', Drivers::class)->name('drivers');
    Route::get('/roles', Roles::class)->name('roles');
    Route::get('/offer-things', OfferThings::class)->name('offer-things');
    Route::get('/trips', Trips::class)->name('trips');
        Route::get('/passenger-types', PassengerTypes::class)->name('passenger-types');
            Route::get('/passenger-list/{tripId}', PassengerList::class)->name('passenger-list');
                Route::get('/settings', Settings::class)->name('settings');



});



});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
