<?php

use App\Modules\Route;

// register class autoloader
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
  $resource = "public/{$_GET['__path']}";
  if (file_exists($resource)) {
    $ext = pathinfo($resource, PATHINFO_EXTENSION);
    $mime = mime_content_type($resource);
    header("Content-Type: $mime");
    if ($ext == "css") {
      header("Content-Type: text/css");
    }
    if ($ext == "js") {
      header("Content-Type: text/javascript");
    }
    readfile($resource);
    die();
  }
}
unset($_GET["__path"]);

// register routes
$routePrefix = "";
include "routes/web.php";
$routePrefix = "api";
// TODO implement api routes
include "routes/api.php";

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


$controller = "App\Controllers\\$routeAction->controller";
$controller = new $controller();


$controller->{$routeAction->method}();
// $actionResult = call_user_func_  array($controller->{$routeAction->method}, $routeParameters);
