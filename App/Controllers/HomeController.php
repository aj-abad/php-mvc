<?php

namespace App\Controllers;

class HomeController extends Controller
{
  public function index(Controller $controller)
  {
    $data = [
      'name' => $controller::class,
    ];
    return $this->view('home', $data);
  }

  public function about()
  {
    return $this->view('about');
  }

  public function testJson()
  {
    $obj = ['Hello' => 'World'];
    return $this->json($obj);
  }

  public function test(Controller $controller, $id)
  {
    $data = [
      'id' => $id,
    ];
    return $data;
  }
}
