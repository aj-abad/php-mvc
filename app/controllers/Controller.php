<?php

namespace App\Controllers;

class Controller
{
  protected $layout = "default";

  protected function view(string $viewPath, ?array $data = []): void
  {
    $viewPath = $_SERVER["DOCUMENT_ROOT"]  . "/app/views/{$viewPath}.php";

    if (!file_exists($viewPath)) {
      throw new \Exception("View not found: $viewPath");
    }

    if ($data) {
      foreach ($data as $key => $value) {
        $$key = htmlspecialchars($value);
      }
    }

    //TODO come up with a better way to do this
    if (!isset($title) || gettype($title) !== "string") {
      $title = "Default title";
    }

    require_once $_SERVER["DOCUMENT_ROOT"]  . "/app/layouts/{$this->layout}.php";
  }

  protected function layout(string $layoutName): void
  {
    $layoutPath = $_SERVER["DOCUMENT_ROOT"]  . "/app/layouts/{$layoutName}.php";

    if (!file_exists($layoutPath)) {
      throw new \Exception("Layout not found: $layoutPath");
      die();
    }
    $this->layout = $layoutName;
  }

  protected function json($object): void
  {
    header("Content-Type: application/json");
    echo json_encode($object);
  }
}
