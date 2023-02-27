<?php

namespace App\Controllers;

use App\Modules\Request;
use App\Modules\Response;
use App\Modules\HttpStatusCode;

class HomeController extends Controller
{
  public function index(Controller $controller) // to test dependency injection
  {
    $data = [
      "name" => $controller::class,
    ];
    return $this->view("home", $data);
  }

  public function about()
  {
    return $this->view("about");
  }

  public function testJson()
  {
    $obj = Request::all();
    return $this->json($obj); // to test json method
  }

  public function test(Controller $controller, $id) // to test dependency injection and route parameters
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