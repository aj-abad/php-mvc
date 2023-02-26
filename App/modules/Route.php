<?php

namespace App\Modules;

enum RequestMethod: string
{
  case GET = "GET";
  case POST = "POST";
  case PUT = "PUT";
  case DELETE = "DELETE";
}

class Route
{
  public static $allRoutes = [
    "GET" => [],
    "POST" => [],
    "PUT" => [],
    "DELETE" => []
  ];

  private static $namedRoutes = [];

  public string $route = "";
  public string $controller = "";
  public string $method = "";

  public array $parameters = [];

  public static function getNamed(string $name): Route
  {
    return self::$namedRoutes[$name];
  }

  public static function register(RequestMethod $requestMethod, string $route, string $controller, string $method): Route
  {
    $parameters = [];

    //convert route to regex and store parameters
    $routeRegex = explode("/", $route);
    foreach ($routeRegex as $index => $routePart) {
      if (str_starts_with($routePart, ":")) {
        array_push($parameters, substr($routePart, 1));
        $routeRegex[$index] = "(.+)";
      }
    }
    $routeRegex = implode("/", $routeRegex);
    $routeRegex = "^{$routeRegex}$";

    //if route already exists
    if (array_key_exists($routeRegex, self::$allRoutes[$requestMethod->value])) {
      throw new \Exception("Route already exists: $route");
      die();
    }

    $routeInstance = new Route($route, $controller, $method, $parameters);

    self::$allRoutes[$requestMethod->value][$routeRegex] = $routeInstance;
    return $routeInstance;
  }

  public function __construct(string $route, string $controller, string $method, $parameters = [])
  {
    $this->route = $route;
    $this->controller = $controller;
    $this->method = $method;
    $this->parameters = $parameters;
  }

  public function named(string $name)
  {
    self::$namedRoutes[$name] = $this->route;
    return $this;
  }
}
