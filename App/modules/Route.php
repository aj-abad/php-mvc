<?php

namespace App\Modules;

enum Action: string
{
  case GET = 'GET';
  case POST = 'POST';
  case PUT = 'PUT';
  case DELETE = 'DELETE';
}

class Route
{
  public static $allRoutes = [
    'GET' => [],
    'POST' => [],
    'PUT' => [],
    'DELETE' => []
  ];

  private static $namedRoutes = [];

  public static function register(Action $action, string $route, string $controller, string $method): Route
  {
    //if route already exists
    if (array_key_exists($route, self::$allRoutes[$action->value])) {
      throw new \Exception('Route already exists: ' . $route);
    }
    self::$allRoutes[$action->value][$route] = [
      'controller' => $controller,
      'method' => $method
    ];


    return new Route();
  }

  public function __construct()
  {
  }

  public function named(string $name)
  {
    self::$namedRoutes[$name] = $this;
    return $this;
  }
}
