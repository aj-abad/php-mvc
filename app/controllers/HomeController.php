<?php

namespace App\Controllers;

use App\Modules\Request;
use App\Modules\Response;
use App\Modules\HttpStatusCode;

class HomeController extends Controller
{
  public function index()
  {
    $data = [];
    return $this->view("home", $data);
  }

  public function about()
  {
    return $this->view("about");
  }

  public function testJson()
  {
    $obj = Request::all();
    return $this->json($obj);
  }

  public function test($id)
  {
    $data = [
      "id" => $id,
    ];
    Response::status(HttpStatusCode::CREATED);
    Response::header("X-Test", "Hello World");
    Response::cookie("test", "Hello World");
    return $data; // to test auto json response
  }
}
