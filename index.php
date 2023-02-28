<?php

use App\Modules\Route;
use App\Modules\View;

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

// enable CORS
header("Access-Control-Allow-Origin: *");
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

// TODO? find a better way to handle route prefixes
// register routes
$routePrefix = "";
include "routes/web.php";
$routePrefix = "/api";
include "routes/api.php";

// find matching route using regex
$routeAction = Route::current();

if (!$routeAction) {
  if ($method === "GET") {
    http_response_code(404);
    require_once "app/views/404.php";
    die();
  }
  http_response_code(404);
  echo json_encode(["error" => "No route found for $requestUri"]);
  die();
}

// get parameters from URI
$controller = $routeAction->controller;
$controller = new $controller();

// call pre middleware
foreach ($routeAction->middleware as $middleware) {
  $middleware = new $middleware();
  $middlewareResult = $middleware->onBeforeExecute();
  if ($middlewareResult) {
    header("Content-Type: application/json");
    echo json_encode($middlewareResult);
    die();
  }
}

// call controller method with route parameters
$actionResult = call_user_func_array([$controller, $routeAction->method], Route::getCurrentRouteParameters());
// call post middleware
foreach ($routeAction->middleware as $middleware) {
  $middleware = new $middleware();
  $middleware->onAfterExecute();
}

// display action result
if (is_array($actionResult)) {
  header("Content-Type: application/json");
  echo json_encode($actionResult);
  die();
}

if (is_a($actionResult, View::class)) {
  $actionResult->renderLayout();
}
