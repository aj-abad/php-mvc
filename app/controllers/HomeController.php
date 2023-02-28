<?php

namespace App\Controllers;

use App\Modules\Request;
use App\Modules\Response;
use App\Modules\HttpStatusCode;
use App\Modules\View;

class HomeController extends Controller
{
  public function index()
  {
    $data = [
      "hello" => "world"
    ];
    return View::make("home", $data)
      ->title("Home page");
  }

  public function about()
  {
    return View::make("about")
      ->title("About page");
  }
}
