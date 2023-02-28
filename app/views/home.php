<?php

use App\Modules\Route;

$currentRoute = Route::current();
?>

<div class="container py-4">
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
</div>