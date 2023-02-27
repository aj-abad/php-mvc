<?php

namespace App\Middleware;

interface Middleware
{
  public function onBeforeExecute();
  public function onAfterExecute();
}
