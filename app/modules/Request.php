<?php

namespace App\Modules;

class Request
{
  public static function method(): string
  {
    return $_SERVER["REQUEST_METHOD"];
  }

  public static function get($key, $default = null)
  {
    return @$_GET[$key] ?? $default;
  }

  public static function post($key, $default = null)
  {
    return @$_POST[$key] ?? $default;
  }

  public static function all(): array
  {
    return array_merge($_GET, $_POST);
  }

  public static function header($key, $default = null): string
  {
    $key = strtoupper(str_replace("-", "_", $key));
    return @$_SERVER["HTTP_$key"] ?? $default;
  }

  public static function cookie($key, $default = null): string
  {
    return @$_COOKIE[$key] ?? $default;
  }

  public static function some(array $keys): array
  {
    $result = [];
    $all = self::all();
    foreach ($keys as $key) {
      if (isset($all[$key])) {
        $result[$key] = $all[$key];
      }
    }
    return $result;
  }
}
