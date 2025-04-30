<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Client Authentication Routes
Route::get('/signup', [ClientController::class, 'showSignupForm'])->name('client.signup'); // Sign Up Form
Route::post('/signup', [ClientController::class, 'register'])->name('client.register'); // Sign Up Logic
Route::get('/signin', [ClientController::class, 'showSigninForm'])->name('client.signin'); // Sign In Form
Route::post('/signin', [ClientController::class, 'login'])->name('client.login'); // Sign In Logic

// Client Dashboard (Protected by auth:client middleware)

// Route::get('/client/dashboard', [ClientController::class, 'dashboard'])->name('user.dashboard');


Route::post('/logout', function () {
    Auth::guard('client')->logout(); // Log out the client
    return redirect('/'); // Redirect to the welcome page
})->name('logout');

// Service Details Page
Route::get('/service-details', function () {
    return view('service-details');
})->name('service.details');

// Admin Dashboard (Protected by auth and verified middleware)
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Admin Settings and Applications Routes (Protected by auth middleware)
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('applications', 'application-list')->name('application.list');
    Volt::route('applications/approved', 'approved-application-list')->name('application.list.approved');
    Volt::route('applications/declined', 'declined-application-list')->name('application.list.declined');
    Volt::route('applications/selected', 'selected-application-list')->name('application.list.selected');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    Volt::route('manage/loans', 'admin.manage-loans')->name('admin.manage.loans');

    Volt::route('user/loan', 'user.loans')->name('user.loans');
    Volt::route('user/dashboard', 'user.dashboard')->name('user.dashboard');
    Volt::route('user/apply-loan', 'user.apply-loan')->name('user.apply-loan');
    Volt::route('user/application-form', 'application-form')->name('user.application-form');
    Volt::route('user/signature/{id}', 'signature-pad')->name('user.signature');
});

// Include Laravel's default authentication routes
require __DIR__.'/auth.php';