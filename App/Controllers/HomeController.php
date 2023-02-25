<?php

namespace App\Controllers;

class HomeController extends Controller
{
  public function index()
  {
    $data = [
      'name' => '<script>alert(1)</script>'
    ];
    return $this->view('home', $data);
  }

  public function about()
  {
    return $this->redirect('index');
  }

  public function testJson()
  {
    $obj = ['Hello' => 'World'];
    return $this->json($obj);
  }
}
