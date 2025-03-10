<?php

use Illuminate\Http\Request;

// Authentification via Sanctum
Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::middleware('auth:sanctum')->post('/logout', 'AuthController@logout');

// Routes pour la gestion des événements (CRUD)
// Les routes de création, mise à jour et suppression sont protégées
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/events', 'EventController@store');
    Route::put('/events/{id}', 'EventController@update');
    Route::delete('/events/{id}', 'EventController@destroy');
});

Route::get('/events', 'EventController@index');
Route::get('/events/{id}', 'EventController@show');
// Route dynamique avec slug et id
Route::get('/events/{slug}/{id}', 'EventController@showBySlug');
