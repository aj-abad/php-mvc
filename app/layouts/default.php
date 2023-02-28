<?php

use App\Modules\Route; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="/favicon.png">
  <title><?= $this->title ?></title>
  <?php $this->renderSection("head"); ?>
</head>

<body>
  <div class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
    <div class="container">
      <a href="<?= Route::getNamed('home') ?>" class="navbar-brand">Test MVC App</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <nav class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="<?= Route::getNamed('home') ?>">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= Route::getNamed('about') ?>">About</a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
  <?php $this->renderBody(); ?>
  <?php //include $bodyScripts; 
  ?>
</body>

</html>