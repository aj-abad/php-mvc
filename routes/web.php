<?php

use App\Modules\Action;
use App\Modules\Route;

Route::register(Action::GET, '/', 'Home', 'index')->named('home');
Route::register(Action::GET, '/about', 'Home', 'about')->named('about');