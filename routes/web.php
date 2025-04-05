<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/service-details', function () {
    return view('service-details');
})->name('service.details');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('applications', 'application-list')->name('application.list');
    Volt::route('applications/approved', 'approved-application-list')->name('application.list.approved');
    Volt::route('applications/declined', 'declined-application-list')->name('application.list.declined');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    // Route::get('/applications', App\Livewire\ApplicationList::class)->name('applications.index');
    // Route::get('/applications/declined', App\Livewire\DeclinedApplicationList::class)->name('applications.declined');
});







require __DIR__.'/auth.php';
