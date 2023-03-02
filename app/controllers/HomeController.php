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
use App\Modules\Auth;

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

  public function signIn()
  {
    $name = Request::post("name");
    $password = Request::post("password");

    $user = DB::query("SELECT * FROM users WHERE name = :name", ["name" => $name]);
    if (!$user) {
      FlashMessages::set("error", "User not found");
      return Response::redirect(Route::getNamed("home"));
    }
    $user = new Models\User($user[0]);
    if (!Hash::verify($password, $user->password)) {
      FlashMessages::set("error", "Invalid password");
      return Response::redirect(Route::getNamed("home"));
    }
    Auth::login($user->toArray());
    return Response::redirect(Route::getNamed("home"));
  }

  public function create()
  {
    $body = Request::all();
    $user = new Models\User($body);
    foreach(get_object_vars($user) as $key => $value) {
      $user->$key = trim($value);
    }
    $user->password = Hash::make($user->password);
    DB::query("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)", $user->toArray());
    FlashMessages::set("success", "New user added successfully");
    return Response::redirect(Route::getNamed("home"));
  }
}
