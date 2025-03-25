<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HandlerController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/viewer', function () {
    return view('viewer');
});

Route::get('/designer', function () {
    return view('designer');
});

Route::any('/handler', [HandlerController::class, 'process']);
