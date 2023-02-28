<?php

use App\Modules\Route;
use App\Modules\View;

// register class autoloader
spl_autoload_register(
  function ($class) {
    $class_path = "../" . str_replace("\\", "/", $class);
    $file = $class_path . ".php";
    // if the file exists, require it
    if (file_exists($file)) {
      require $file;
    }
  }
);

// enable CORS
header("Access-Control-Allow-Origin: *");

// TODO? find a better way to handle route prefixes
// register routes
$routePrefix = "";
require "../routes/web.php";
$routePrefix = "/api";
require "../routes/api.php";

// find matching route using regex
$routeAction = Route::current();

if (!$routeAction) {
  if ($_SERVER["REQUEST_METHOD"] === "GET") {
    http_response_code(404);
    require_once "../app/views/404.php";
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

// display view
if (is_a($actionResult, View::class)) {
  $actionResult->renderLayout();
  die();
}

// output json for any other result
if (($actionResult)) {
  header("Content-Type: application/json");
  echo json_encode($actionResult);
  die();
}
