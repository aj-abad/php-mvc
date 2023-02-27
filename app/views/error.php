<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    <?= $e->getMessage() ?>
  </title>
  <link rel="stylesheet" href="/public/css/bootstrap.min.css">
</head>

<body style="height: 100vh" class="p-4">
  <div class="">
    <h1 class="h3">
      <?= $e->getMessage() ?>
    </h1>
    <code>
      <pre><?= $e->getTraceAsString(); ?></pre>
    </code>
  </div>
</body>

</html>