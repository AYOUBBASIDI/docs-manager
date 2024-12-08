<?php

use Illuminate\Support\Facades\Route;
// routes/web.php
use App\Http\Controllers\PageController;

// Place specific routes first
Route::get('/pages/create', [PageController::class, 'create'])->name('pages.create');
Route::get('/pages/{id}/edit', [PageController::class, 'edit'])->name('pages.edit');

// Then the catch-all route for showing pages
Route::get('/pages/{path?}', [PageController::class, 'show'])
    ->where('path', '.*')
    ->name('pages.show');

// Finally the rest of the resource routes
Route::resource('pages', PageController::class)
    ->except(['show', 'create', 'edit']);

    