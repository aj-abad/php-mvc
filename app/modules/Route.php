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
  public string $pattern = "";
  public string $name = "";
  public array $middleware = [];

  public function __call($name, $arguments)
  {
    if ($name == "middleware") {
      $this->middleware = $arguments[0];
      return $this;
    }
  }

  public array $parameters = [];

  public static function getSanitizedUri(): string
  {
    $requestUri = $_SERVER["REQUEST_URI"];
    $requestUri = preg_replace("/\/+/", "/", $requestUri);
    $requestUri = explode("?", $requestUri)[0];

    return $requestUri;
  }

  public static function getCurrentRouteParameters(): array
  {
    $routeParameters = [];
    $currentRoute = self::current();
    preg_match("#{$currentRoute->pattern}#", self::getSanitizedUri(), $routeParameters);
    array_shift($routeParameters);
    $routeParameters = array_combine($currentRoute->parameters, $routeParameters);
    return $routeParameters;
  }

  public static function current(): ?Route
  {
    $uri = self::getSanitizedUri();
    $route = (array_filter(
      Route::$allRoutes[$_SERVER["REQUEST_METHOD"]],
      function ($route) use ($uri) {
        return preg_match("#$route#", $uri);
      },
      ARRAY_FILTER_USE_KEY
    ));

    if (count($route) == 0) {
      return null;
    }

    return array_values($route)[0];
    return $route;
  }

  public static function getNamed(string $name, array $parameters = []): string
  {
    $route = @self::$namedRoutes[$name];
    if (!$route) {
      throw new \Exception("Named route not found: $name");
      die();
    }

    //replace route parts with parameters
    $routeParts = explode("/", $route->route);
    foreach ($routeParts as $index => $routePart) {
      if (str_starts_with($routePart, ":")) {
        $routeParts[$index] = $parameters[substr($routePart, 1)];
      }
    }
    $routeWithParameters = implode("/", $routeParts);

    return $routeWithParameters;
  }

  public static function register(RequestMethod $requestMethod, string $route, string $controller, string $method): Route
  {
    global $routePrefix;
    $route = $routePrefix . $route;
    $parameters = [];

    //convert route to regex and store parameters
    $routeRegex = explode("/", $route);
    foreach ($routeRegex as $index => $routePart) {
      if (str_starts_with($routePart, ":")) {
        array_push($parameters, substr($routePart, 1));
        $routeRegex[$index] = "([^/]+)";
      }
    }
    $routeRegex = implode("/", $routeRegex);
    $routeRegex = "^{$routeRegex}\/*$";

    //if route already exists
    if (array_key_exists($routeRegex, self::$allRoutes[$requestMethod->value])) {
      throw new \Exception("Route already exists: $route");
      die();
    }

    $routeInstance = new Route();
    $routeInstance->route = $route;
    $routeInstance->controller = $controller;
    $routeInstance->method = $method;
    $routeInstance->pattern = $routeRegex;
    $routeInstance->parameters = $parameters;
    self::$allRoutes[$requestMethod->value][$routeRegex] = $routeInstance;
    return $routeInstance;
  }

  public function named(string $name): Route
  {
    if (array_key_exists($name, self::$namedRoutes)) {
      throw new \Exception("Named route already exists: $name");
      die();
    }
    $this->name = $name;
    self::$namedRoutes[$name] = $this;
    return $this;
  }

  public function middleware(array $middleware): Route
  {
    foreach ($middleware as $middlewareClass) {
      if (!class_exists($middlewareClass)) {
        throw new \Exception("Middleware class not found: $middlewareClass");
        die();
      }
      array_push($this->middleware, $middlewareClass);
    }
    return $this;
  }
}
