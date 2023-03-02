<?php

namespace App\Modules;

class Auth
{
  public static function isLoggedIn()
  {
    return isset($_SESSION["user"]);
  }

  public static function login(array $user)
  {
    $_SESSION["user"] = $user;
  }

  public static function user()
  {
    return @$_SESSION["user"] ?? null;
  }
}
