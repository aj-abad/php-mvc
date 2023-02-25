<?php

namespace App\Controllers;

class HomeController extends Controller
{
  public function index()
  {
    return $this->view('home');
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
