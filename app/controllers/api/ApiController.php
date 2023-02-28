<?php

namespace App\Controllers\API;

use App\Controllers\Controller;
use App\Modules\HttpStatusCode;
use App\Modules\Route;
use App\Modules\RequestMethod;
use App\Modules\Request;
use App\Modules\Response;

class ApiController extends Controller
{

  public function index($id)
  {
    Response::header("X-Hello", "World");
    Response::cookie("hello", "world", 3600);
    Response::status(HttpStatusCode::CREATED);
    return [
      "id" => $id,
    ];
  }
}
