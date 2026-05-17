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
    //Route::get('/utilisateur/create', [DashboardController::class, 'createUtilisateur'])->name('dashboard.utilisateur.create');
    Route::post('/utilisateur', [DashboardController::class, 'saveUtilisateur'])->name('dashboard.saveUtilisateur');
    Route::get('/utilisateur/{id}/edit', [DashboardController::class, 'editUtilisateur'])->name('dashboard.editUtilisateur');
    Route::put('/utilisateur/{id}', [DashboardController::class, 'updateUtilisateur'])->name('dashboard.updateUtilisateur');
    Route::delete('/utilisateur/{id}', [DashboardController::class, 'deleteUtilisateur'])->name('dashboard.deleteUtilisateur');
    
    Route::get('/roles', [DashboardController::class, 'roles'])->name('dashboard.roles');
    //Route::get('/role/create', [DashboardController::class, 'createRole'])->name('dashboard.role.create');
    Route::post('/role', [DashboardController::class, 'saveRole'])->name('dashboard.saveRole');
    Route::get('/role/{id}/edit', [DashboardController::class, 'editRole'])->name('dashboard.role.edit');
    Route::put('/role/{id}', [DashboardController::class, 'updateRole'])->name('dashboard.updateRole');
    Route::delete('/role/{id}', [DashboardController::class, 'deleteRole'])->name('dashboard.deleteRole');
    
    Route::get('/mines', [DashboardController::class, 'mines'])->name('dashboard.mines');
    //Route::get('/mine/create', [DashboardController::class, 'createMine'])->name('dashboard.mine.create');
    Route::post('/mine', [DashboardController::class, 'saveMine'])->name('dashboard.saveMine');
    Route::get('/mine/{id}/edit', [DashboardController::class, 'editMine'])->name('dashboard.mine.edit');
    Route::put('/mine/{id}', [DashboardController::class, 'updateMine'])->name('dashboard.updateMine');
    Route::delete('/mine/{id}', [DashboardController::class, 'deleteMine'])->name('dashboard.deleteMine');
    
    Route::get('/concessions', [DashboardController::class, 'concessions'])->name('dashboard.concessions');
    //Route::get('/concession/create', [DashboardController::class, 'createConcession'])->name('dashboard.concession.create');
    Route::post('/concession', [DashboardController::class, 'saveConcession'])->name('dashboard.saveConcession');
    Route::get('/concession/{id}/edit', [DashboardController::class, 'editConcession'])->name('dashboard.concession.edit');
    Route::put('/concession/{id}', [DashboardController::class, 'updateConcession'])->name('dashboard.updateConcession');
    Route::delete('/concession/{id}', [DashboardController::class, 'deleteConcession'])->name('dashboard.deleteConcession');
    
    Route::get('/sites', [DashboardController::class, 'sites'])->name('dashboard.sites');
    Route::get('/site/create', [DashboardController::class, 'createSite'])->name('dashboard.site.create');
    Route::post('/site', [DashboardController::class, 'saveSite'])->name('dashboard.saveSite');
    Route::get('/site/{id}/edit', [DashboardController::class, 'editSite'])->name('dashboard.site.edit');
    Route::put('/site/{id}', [DashboardController::class, 'updateSite'])->name('dashboard.updateSite');
    Route::delete('/site/{id}', [DashboardController::class, 'deleteSite'])->name('dashboard.deleteSite');
    
    Route::get('/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('dashboard.profile.update');
});

// Route pour générer l'image d'un lot avec QR code
Route::get('/lot/{id}/image', [LotController::class, 'generateImage'])->name('lot.image');
