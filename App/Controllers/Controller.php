<?php

namespace App\Controllers;

class Controller
{


  protected function view(string $viewPath): void
  {
    $viewPath = $_SERVER['DOCUMENT_ROOT']  . '/mvc' . '/app/views/' . $viewPath . '.php';
    if (file_exists($viewPath)) {
      require_once $viewPath;
    } else {
      throw new \Exception('View not found: ' . $viewPath);
    }
  }
}
