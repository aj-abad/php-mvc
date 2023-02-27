<?php

use App\Controllers\API\ApiController;
use App\Modules\Route;
use App\Modules\RequestMethod;
use App\Middleware\TestMiddleware;

Route::register(RequestMethod::GET, "/test/:id", ApiController::class, "index")
  ->named("apiTest")
  ->middleware([TestMiddleware::class]);
