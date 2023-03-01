<?php

namespace App\Modules;

class FlashMessages
{
  public static function set($key, $value)
  {
    $_SESSION["flashMessages"][$key] = $value;
  }

  public static function get($key)
  {
    return @$_SESSION["flashMessages"][$key] ?? null;
  }

  public static function clear()
  {
    unset($_SESSION["flashMessages"]);
  }
}
