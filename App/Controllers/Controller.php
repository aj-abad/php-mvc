<?php

namespace App\Controllers;

class Controller
{
  protected function view(string $viewPath, ?array $data = null): void
  {
    $viewPath = $_SERVER['DOCUMENT_ROOT']  . '/app/views/' . $viewPath . '.php';

    if (!file_exists($viewPath)) {
      throw new \Exception('View not found: ' . $viewPath);
    }

    if ($data) {
      foreach ($data as $key => $value) {
        $$key = htmlspecialchars($value);
      }
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
