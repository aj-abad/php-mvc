<?php

namespace App\Modules;

enum RequestMethod: string
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

  public string $route = '';

  public static function getNamed(string $name): Route
  {
    return self::$namedRoutes[$name];
  }

  public static function register(RequestMethod $requestMethod, string $route, string $controller, string $action): Route
  {
    //if route already exists
    if (array_key_exists($route, self::$allRoutes[$requestMethod->value])) {
      throw new \Exception('Route already exists: ' . $route);
    }
    self::$allRoutes[$requestMethod->value][$route] = [
      'controller' => $controller,
      'action' => $action
    ];

    return new Route($route);
  }

  public function __construct(string $route)
  {
    $this->route = $route;
  }

  public function named(string $name)
  {
    self::$namedRoutes[$name] = $this->route;
    return $this;
  }
}
