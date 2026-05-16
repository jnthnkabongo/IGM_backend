<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LotController;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Routes d'authentification
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes du dashboard (protégées par authentification)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/utilisateurs', [DashboardController::class, 'utilisateurs'])->name('dashboard.utilisateurs');
    Route::get('/utilisateur/create', [DashboardController::class, 'createUtilisateur'])->name('dashboard.utilisateur.create');
    Route::post('/utilisateur', [DashboardController::class, 'saveUtilisateur'])->name('dashboard.saveUtilisateur');
    Route::get('/utilisateur/{id}/edit', [DashboardController::class, 'editUtilisateur'])->name('dashboard.editUtilisateur');
    Route::put('/utilisateur/{id}', [DashboardController::class, 'updateUtilisateur'])->name('dashboard.updateUtilisateur');
    Route::delete('/utilisateur/{id}', [DashboardController::class, 'deleteUtilisateur'])->name('dashboard.deleteUtilisateur');
    
    Route::get('/roles', [DashboardController::class, 'roles'])->name('dashboard.roles');
    Route::get('/role/create', [DashboardController::class, 'createRole'])->name('dashboard.role.create');
    Route::post('/role', [DashboardController::class, 'saveRole'])->name('dashboard.saveRole');
    Route::get('/role/{id}/edit', [DashboardController::class, 'editRole'])->name('dashboard.role.edit');
    Route::put('/role/{id}', [DashboardController::class, 'updateRole'])->name('dashboard.updateRole');
    Route::delete('/role/{id}', [DashboardController::class, 'deleteRole'])->name('dashboard.deleteRole');
    
    Route::get('/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('dashboard.profile.update');
});

// Route pour générer l'image d'un lot avec QR code
Route::get('/lot/{id}/image', [LotController::class, 'generateImage'])->name('lot.image');
