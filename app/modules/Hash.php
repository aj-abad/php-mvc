<?php

namespace App\Modules;

class Hash
{
  public static function make($string): string
  {
    return password_hash($string, PASSWORD_ARGON2I);
  }

  public static function verify($string, $hash): bool
  {
    return password_verify($string, $hash);
  }
}
