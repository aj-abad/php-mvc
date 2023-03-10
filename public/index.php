<?php

use App\Modules\Route;
use App\Modules\DotEnv;
use App\Modules\FlashMessages;
use App\Modules\View;
use App\Modules\Response;

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

// if php://input is valid json, combine it with $_POST
if (isset($_SERVER["CONTENT_TYPE"]) && $_SERVER["CONTENT_TYPE"] === "application/json") {
  $json = json_decode(file_get_contents("php://input"), true);
  if ($json) {
    $_POST = array_merge($_POST, $json);
  }
}

// register environment variables
DotEnv::load();

// enable CORS
header("Access-Control-Allow-O6rigin: *");

// start session securely and make it last for 12 hours
session_start(['cookie_lifetime' => 3600 * 12, 'cookie_secure' => true, 'cookie_httponly' => true]);

// TODO? find a better way to handle route prefixes
// register routes
$routePrefix = "";
require "../routes/web.php";
$routePrefix = "/api";
require "../routes/api.php";

// find matching route using regex
$matchedRoute = Route::current();

// handle 404
if (!$matchedRoute) {
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
$controller = $matchedRoute->controller;
$controller = new $controller();

$actionResult = null;

// call pre middleware
foreach ($matchedRoute->middleware as $middleware) {
  $middleware = new $middleware();
  $middlewareResult = $middleware->onBeforeExecute();
  if ($middlewareResult) {
    $actionResult = $middlewareResult;
    break;
  }
}

// proceed to controller method if request is not intercepted by middleware
if (!$actionResult) {
  $actionResult = call_user_func_array([$controller, $matchedRoute->method], Route::getCurrentRouteParameters());
}

// call post middleware
foreach ($matchedRoute->middleware as $middleware) {
  $middleware = new $middleware();
  $middleware->onAfterExecute();
}

// display view
if (is_a($actionResult, View::class)) {
  $actionResult->renderLayout();
  FlashMessages::clear();
  die();
}

// output json for any other result
Response::header("Content-Type", "application/json");
echo json_encode($actionResult);
die();
