<?php

use App\Modules\FlashMessages;
use App\Modules\Route;
use App\Modules\View;

$currentRoute = Route::current();
?>

<div class="container py-4">
  <?php if (FlashMessages::get("success")) : ?>
    <div class="alert alert-success" role="alert">
      <?= FlashMessages::get("success") ?>
    </div>
  <?php endif; ?>

  <h1>
    Home
  </h1>
  <p class="mb-4">
    This is the home page
  </p>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($this->viewData["users"] as $user) : ?>
        <tr>
          <th scope="row"><?= $user["id"] ?></th>
          <td><?= $user["name"] ?></td>
          <td><?= $user["email"] ?></td>
        </tr>
      <?php endforeach; ?>
  </table>

  <form action="<?= Route::getNamed('home.post')  ?>" method="POST">
    <h2>
      Create new user
    </h2>
    <div class="mb-2">
      <input type="text" name="name" class="form-control" placeholder="Name" aria-label="Name" />
    </div>
    <div class="mb-2">
      <input type="text" name="email" class="form-control" placeholder="Email" aria-label="Email" />
    </div>
    <div class="mb-2">
      <input type="text" name="password" class="form-control" placeholder="Password" aria-label="Password" />
    </div>
    <button type="submit" class="btn btn-primary">
      Save
    </button>
  </form>
</div>