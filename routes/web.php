<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return auth()->check() ? redirect('/home') : redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth');

// Ruta catch-all para Vue (debe ir al final)
Route::get('/{any}', function () {
    if (auth()->check()) {
        return redirect('/home');
    }
    return redirect()->route('login');
})->where('any', '.*');