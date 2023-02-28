<?php

namespace App\Controllers;

use App\Modules\DB;
use App\Modules\Request;
use App\Modules\Response;
use App\Modules\HttpStatusCode;
use App\Modules\View;
use App\Models;
use App\Modules\Route;

class HomeController extends Controller
{
  public function index()
  {
    $data = [
      "hello" => "world"
    ];

    $usersData = DB::query("SELECT * FROM users");
    $usersData = array_map(function ($user) {
      return new Models\User($user);
    }, $usersData);

    return View::make("home", ["users" => $usersData])
      ->title("Home page");
  }

  public function about()
  {
    return View::make("about")
      ->title("About page");
  }

  public function create()
  {
    $all = Request::all();
    $user = new Models\User(Request::all());
    DB::query("INSERT INTO users (name, email, password) VALUES (:name, :email, '123213123')", get_object_vars($user));
    Response::header("Location", Route::getNamed("home"));
    Response::status(HttpStatusCode::FOUND);
    return null;
  }
}
