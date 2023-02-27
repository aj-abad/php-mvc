<?php

use App\Modules\Route; ?>

<div class="container">
  <h1>
    Home
  </h1>
  <p class="mb-4">
    This is the home page
  </p>
  <p>
    <a href="<?= Route::getNamed('about')->route ?>">About page</a>
  </p>
</div>