<?php
use App\Controllers\HomeController;
use App\Modules\RequestMethod;
use App\Modules\Route;

Route::register(RequestMethod::GET, "/", HomeController::class, "index")->named("home");
Route::register(RequestMethod::GET, "/about", HomeController::class, "about")->named("about");
