<?php

namespace App\Controllers;

class Controller
{
  protected function view(string $viewPath): void
  {
    $viewPath = $_SERVER['DOCUMENT_ROOT']  . '/app/views/' . $viewPath . '.php';
    if (!file_exists($viewPath)) {
      throw new \Exception('View not found: ' . $viewPath);
    }
    require_once $viewPath;
  }

  protected function redirect(string $action): void
  {
    if (!is_callable([$this, $action])) {
      throw new \Exception('Action not found: ' . $action);
    }
    $this->{$action}();
  }

  protected function json($object): void
  {
    header('Content-Type: application/json');
    echo json_encode($object);
  }
}
