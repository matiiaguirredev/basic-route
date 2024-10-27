<?php

use App\Controllers\HomeController;
use Lib\Route;

Route::get('/', [HomeController::class, "index"]);

Route::get('/contact', function () {
    echo "hola desde contacto";
});

Route::get('/about', function () {
    echo "hola desde about me";
});

Route::get('/cursos/:slug', function ($slug) {
    return "Hola desde el curso: " . $slug;
});

Route::dispatch();
