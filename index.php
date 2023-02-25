<?php

use App\Modules\Route;

// custom psr-4 autoloader
spl_autoload_register(
  function ($class) {
    $class_path = str_replace('\\', '/', $class);
    $file =  '' . $class_path . '.php';
    // if the file exists, require it
    if (file_exists($file)) {
      require $file;
    }
  }
);

//load resource from public folder if it exists
if (isset($_GET['__path'])) {
  $resource = 'public/' . $_GET['__path'];
  if (file_exists($resource)) {
    $ext = pathinfo($resource, PATHINFO_EXTENSION);
    $mime = mime_content_type($resource);
    header('Content-Type: ' . $mime);
    readfile($resource);
    die();
  }
}

// register routes
include 'routes/web.php';
include 'routes/api.php';

// sanitize URI
$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = preg_replace('/\/+/', '/', $requestUri);
$requestUri = explode('?', $requestUri)[0];
$method = $_SERVER['REQUEST_METHOD'];

// get the route action
$routeAction = @Route::$allRoutes[$method][$requestUri] ?? null;

if (!$routeAction) {
  http_response_code(404);
  require_once 'app/views/404.php';
  die();
}

$controllerPath = 'App\Controllers\\' . $routeAction['controller'];
$controller =  new $controllerPath();
$actionResult = $controller->{$routeAction['action']}();

if ($actionResult) {
  header('Content-Type: application/json');
  echo json_encode($actionResult);
}
