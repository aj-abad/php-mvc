<?php
use App\Modules\RequestMethod;
use App\Modules\Route;

Route::register(RequestMethod::GET, '/', HomeController::class, 'index')->named('home');
Route::register(RequestMethod::GET, '/about', HomeController::class, 'about')->named('about');
Route::register(RequestMethod::GET, '/test/:id/add', HomeController::class, 'test')->named('about');

