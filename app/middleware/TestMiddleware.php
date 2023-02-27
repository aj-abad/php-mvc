<?php

namespace App\Middleware;

use App\Modules\HttpStatusCode;
use App\Modules\Request;
use App\Modules\Response;

class TestMiddleware implements Middleware
{
  public function onBeforeExecute()
  {
    Response::header("X-Before", "test");
    Response::status(HttpStatusCode::FORBIDDEN);

    return [
      "test" => "test"
    ];
  }

  public function onAfterExecute()
  {
    Response::header("X-After", "test");
  }
}
