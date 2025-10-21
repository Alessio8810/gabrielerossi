<?php

use App\Http\Controllers\ArtisanController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

// Public Routes
Route::get('/', function () {
    return view('home');
})->name('home');

// Test route per debug asset
Route::get('/test-assets', function () {
    return view('test-assets');
});

Route::view('/vehicles', 'vehicles')->name('vehicles');

Route::get('/vehicles/{vehicleId}', function ($vehicleId) {
    return view('public.vehicle-detail', ['vehicleId' => $vehicleId]);
})->name('vehicles.show');

// Admin Routes (Protected)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
    
    // Artisan Commands (Only for admin@rossiauto.com)
    Route::get('/artisan', [ArtisanController::class, 'index'])->name('artisan');
    Route::get('/artisan/clear-all', [ArtisanController::class, 'clearAll'])->name('artisan.clear-all');
    
    // Vehicle Management
    Route::view('/vehicles', 'admin.vehicles.index')->name('vehicles');
    Route::view('/vehicles/create', 'admin.vehicles.form')->name('vehicles.create');
    Route::get('/vehicles/{vehicleId}/edit', function ($vehicleId) {
        return view('admin.vehicles.form', ['vehicleId' => $vehicleId]);
    })->name('vehicles.edit');
    
    // Brand Management
    Route::view('/brands', 'admin.brands.index')->name('brands');
    Route::view('/brands/create', 'admin.brands.form')->name('brands.create');
    Route::get('/brands/{brandId}/edit', function ($brandId) {
        return view('admin.brands.form', ['brandId' => $brandId]);
    })->name('brands.edit');
    
    // Car Model Management
    Route::view('/models', 'admin.models.index')->name('models');
    Route::view('/models/create', 'admin.models.form')->name('models.create');
    Route::get('/models/{modelId}/edit', function ($modelId) {
        return view('admin.models.form', ['modelId' => $modelId]);
    })->name('models.edit');
    
    // User Management
    Route::view('/users', 'admin.users.index')->name('users');
    Route::view('/users/create', 'admin.users.form')->name('users.create');
    Route::get('/users/{userId}/edit', function ($userId) {
        return view('admin.users.form', ['userId' => $userId]);
    })->name('users.edit');
});

// Legacy dashboard route (redirect to admin.dashboard)
Route::redirect('/dashboard', '/admin/dashboard')->middleware(['auth', 'verified']);

// Settings (existing)
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
