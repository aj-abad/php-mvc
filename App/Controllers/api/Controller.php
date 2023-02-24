<?php

namespace App\Controllers\API;

class Controller
{
  protected function json(object $object): void
  {
    header('Content-Type: application/json');
    echo json_encode($object);
    die();
  }
}
