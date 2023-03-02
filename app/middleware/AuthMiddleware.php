<?php

namespace App\Middleware;

use App\Modules\Auth;
use App\Modules\FlashMessages;
use App\Modules\HttpStatusCode;
use App\Modules\Request;
use App\Modules\Response;
use App\Modules\Route;

class AuthMiddleware implements Middleware
{
  public function onBeforeExecute()
  {
    if (!Auth::isLoggedIn()) {
      FlashMessages::set("error", "You must be logged in to access this page.");
      return Response::redirect(Route::getNamed("home"));
    }
  }

  public function onAfterExecute()
  {
  }
}
