<?php
use App\Controllers\API\ApiController;
use App\Modules\Route;
use App\Modules\RequestMethod;

Route::register(RequestMethod::GET, "/test/:id", ApiController::class, "index")->named("apiTest");