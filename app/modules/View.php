<?php

namespace App\Modules;

class View
{
  public array $viewData = [];
  public string $layout = "default";
  public string $view = "";
  public string $title = "Default title";

  public array $sections = [
    "head" => "head",
    "bodyScripts" => ""
  ];

  public static function make(string $viewName, array $viewData = []): View
  {
    $view = new View();
    $view->view = $viewName;

    // function for recursive data sanitizing
    $recursiveSanitize = function ($arr) use (&$recursiveSanitize) {
      foreach ($arr as $key => $value) {
        if (is_array($value)) {
          $arr[$key] = $recursiveSanitize($value);
        } else {
          $arr[$key] = htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE);
        }
      }
      return $arr;
    };

    $dataSanitized = $recursiveSanitize($viewData);

    $view->viewData = $dataSanitized;
    return $view;
  }

  public function layout(string $layoutName): View
  {
    $layoutPath = $_SERVER["DOCUMENT_ROOT"]  . "/app/layouts/{$layoutName}.php";

    if (!file_exists($layoutPath)) {
      throw new \Exception("Layout not found: $layoutPath");
      die();
    }
    $this->layout = $layoutName;
    return $this;
  }

  public function renderLayout()
  {
    require_once $_SERVER["DOCUMENT_ROOT"] . "/app/layouts/{$this->layout}.php";
  }

  public function renderBody()
  {
    require_once $_SERVER["DOCUMENT_ROOT"] . "/app/views/{$this->view}.php";
  }

  public function title(string $title): View
  {
    $this->title = htmlspecialchars($title, ENT_QUOTES);
    return $this;
  }

  public function section(string $sectionName, string $sectionContent)
  {
    if (!file_exists($_SERVER["DOCUMENT_ROOT"] . "/app/views/partials/{$this->layout}.php")) {
      throw new \Exception("Layout not found: $sectionName");
      die();
    }

    $this->sections[$sectionName] = $sectionContent;
  }

  public function renderSection(string $sectionName)
  {
    require_once($_SERVER["DOCUMENT_ROOT"] . "/app/views/partials/{$this->sections[$sectionName]}.php");
  }
}
