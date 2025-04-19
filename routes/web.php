<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;

use App\Http\Controllers\AdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard route for patients (role = 2)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('role:2')->name('dashboard');

    // Admin dashboard (role = 0)
    Route::get('/admin/dashboard', function () {
        return view('admin');
    })->middleware('role:0')->name('admin');

    // Profile routes (accessible to all authenticated users)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Patient-specific routes (role = 2)
Route::middleware('auth')->group(function () {
    Route::resource('appointments', AppointmentController::class)->except(['edit', 'update']);
});

// Doctor-specific routes (role = 1)
Route::middleware(['auth', 'role:1'])->group(function () {
    // Manage availability slots
    Route::get('/doctor/schedules', [DoctorController::class, 'schedules'])->name('doctor.schedules');
    Route::post('/doctor/schedules', [DoctorController::class, 'storeSchedule'])->name('doctor.schedules.store');

    // View scheduled appointments
    Route::get('/doctor/appointments', [DoctorController::class, 'appointments'])->name('doctor.appointments');

    // Update an appointment
    Route::put('/doctor/appointments/{appointment}', [DoctorController::class, 'updateAppointment'])
        ->name('doctor.appointments.update');

    // Cancel or modify an appointment
    Route::delete('/doctor/appointments/{appointment}', [DoctorController::class, 'cancelAppointment'])
        ->name('doctor.appointments.cancel');
});


Route::middleware(['auth', 'role:0'])->group(function () {
    // Tableau de bord
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Gestion des utilisateurs
    Route::get('/admin/users', [AdminController::class, 'indexUsers'])->name('admin.users.index');
    Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    // Gestion des créneaux horaires
    Route::get('/admin/creneaux', [AdminController::class, 'indexCreneaux'])->name('admin.creneaux.index');
    Route::get('/admin/creneaux/create', [AdminController::class, 'createCreneau'])->name('admin.creneaux.create');
    Route::post('/admin/creneaux', [AdminController::class, 'storeCreneau'])->name('admin.creneaux.store');
    Route::get('/admin/creneaux/{schedule}/edit', [AdminController::class, 'editCreneau'])->name('admin.creneaux.edit');
    Route::put('/admin/creneaux/{schedule}', [AdminController::class, 'updateCreneau'])->name('admin.creneaux.update');
    Route::delete('/admin/creneaux/{schedule}', [AdminController::class, 'destroyCreneau'])->name('admin.creneaux.destroy');

    // Gestion des rendez-vous
    Route::get('/admin/rendezvous', [AdminController::class, 'indexRendezVous'])->name('admin.rendezvous.index');
    Route::get('/admin/rendezvous/{appointment}/edit', [AdminController::class, 'editRendezVous'])->name('admin.rendezvous.edit');
    Route::put('/admin/rendezvous/{appointment}', [AdminController::class, 'updateRendezVous'])->name('admin.rendezvous.update');
    Route::delete('/admin/rendezvous/{appointment}', [AdminController::class, 'destroyRendezVous'])->name('admin.rendezvous.destroy');
});



// Authentication routes (login, register, etc.)
require __DIR__.'/auth.php';