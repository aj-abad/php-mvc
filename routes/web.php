<?php
use App\Controllers\HomeController;
use App\Modules\RequestMethod;
use App\Modules\Route;

Route::register(RequestMethod::GET, "/", HomeController::class, "index")->named("home");
Route::register(RequestMethod::GET, "/about", HomeController::class, "about")->named("about");
Route::register(RequestMethod::POST, "/", HomeController::class, "create")->named("home.post");
Route::register(RequestMethod::POST, "/sign-in", HomeController::class, "signIn")->named("signin");
