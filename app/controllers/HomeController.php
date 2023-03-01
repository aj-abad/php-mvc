<?php

namespace App\Controllers;

use App\Modules\DB;
use App\Modules\Request;
use App\Modules\Response;
use App\Modules\HttpStatusCode;
use App\Modules\View;
use App\Models;
use App\Modules\FlashMessages;
use App\Modules\Hash;
use App\Modules\Route;

class HomeController extends Controller
{
  public function index()
  {
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
    $user = new Models\User(Request::all());
    $user->password = Hash::make($user->password);
    DB::query("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)", $user->toArray());
    FlashMessages::set("success", "New user added successfully");
    Response::status(HttpStatusCode::SEE_OTHER);
    Response::header("Location", Route::getNamed("home"));
  }
}
