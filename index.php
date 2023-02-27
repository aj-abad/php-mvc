<?php

use App\Modules\Route;

// register class autoloaders
require("vendor/autoload.php");
spl_autoload_register(
  function ($class) {
    $class_path = str_replace("\\", "/", $class);
    $file = $class_path . ".php";
    // if the file exists, require it
    if (file_exists($file)) {
      require $file;
    }
  }
);

// load resource from public folder if it exists
if (isset($_GET["__path"])) {
  if (file_exists("public/{$_GET['__path']}")) {
    $ext = pathinfo($resource, PATHINFO_EXTENSION);
    $mime = mime_content_type($resource);
    header("Content-Type: $mime");
    readfile($resource);
    die();
  }
}
unset($_GET["__path"]);

try {
  // register routes
  include "routes/web.php";
  include "routes/api.php";

  // create dependency injection container for controllers
  $container = new DI\Container();

  // sanitize URI
  $requestUri = $_SERVER["REQUEST_URI"];
  $requestUri = preg_replace("/\/+/", "/", $requestUri);
  $requestUri = explode("?", $requestUri)[0];
  $method = $_SERVER["REQUEST_METHOD"];

  // find matching route using regex
  $routeAction = (array_filter(
    Route::$allRoutes[$method],
    function ($route) use ($requestUri) {
      return preg_match("#$route#", $requestUri);
    },
    ARRAY_FILTER_USE_KEY
  ));
  $routeRegex = array_key_first($routeAction);
  $routeAction = current($routeAction);


  if (!$routeAction) {
    http_response_code(404);
    require_once "app/views/404.php";
    die();
  }

  // get parameters from URI
  $routeParameters = [];
  preg_match("#$routeRegex#", $requestUri, $routeParameters);
  array_shift($routeParameters);

  $routeParameters = array_combine($routeAction->parameters, $routeParameters);

  $controller =  $container->get("App\Controllers\\$routeAction->controller");
  $actionResult = $container->call([$controller, $routeAction->method], $routeParameters);


  if ($actionResult) {
    header("Content-Type: application/json");
    echo json_encode($actionResult);
  }
} catch (Exception $e) {
  // show pretty error page
  http_response_code(500);
  require_once "app/views/error.php";
}
