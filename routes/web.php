<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;

/*
|--------------------------------------------------------------------------
| Routes API (via Sanctum)
|--------------------------------------------------------------------------
*/
// Pour des usages API, vous pouvez garder ces routes en parallèle
Route::post('/api/register', [AuthController::class, 'register']);
Route::post('/api/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/api/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/api/events', [EventController::class, 'store']);
    Route::put('/api/events/{id}', [EventController::class, 'update']);
    Route::delete('/api/events/{id}', [EventController::class, 'destroy']);
});

Route::get('/api/events', [EventController::class, 'index']);
Route::get('/api/events/{id}', [EventController::class, 'show']);
Route::get('/api/events/{slug}/{id}', [EventController::class, 'showBySlug']);

/*
|--------------------------------------------------------------------------
| Routes WEB (Vues Blade)
|--------------------------------------------------------------------------
*/

// Page d'accueil avec bandeau et explication
Route::get('/', function () {
    return view('welcome');  // resources/views/welcome.blade.php
})->name('welcome');

// Formulaires d'authentification
Route::get('/login', function () {
    return view('auth.login');
})->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/register', function () {
    return view('auth.register');
})->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Pages publiques d'affichage des événements
Route::get('/events-view', [EventController::class, 'indexView'])->name('events.index');
Route::get('/events-view/{slug}/{id}', [EventController::class, 'showView'])->name('events.show');

// Groupement des routes web protégées (uniquement pour utilisateurs connectés)
Route::middleware('auth')->group(function () {
    // Dashboard personnalisé
    Route::get('/dashboard', [EventController::class, 'dashboard'])->name('dashboard');

    // Création d'un événement
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events/create', [EventController::class, 'store'])->name('events.store');

    // Edition d'un événement (pour son propriétaire)
    Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{id}/update', [EventController::class, 'updateWeb'])->name('events.updateWeb');

    // Suppression via formulaire (pour éviter l'appel direct en GET)
    Route::delete('/events/{id}/delete', [EventController::class, 'destroy'])->name('events.delete');
});
