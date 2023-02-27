<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Not found</title>
  <link rel="stylesheet" href="/public/css/bootstrap.min.css">
</head>

<body style="height: 100vh" class="d-flex justify-content-center align-items-center">
  <div class="text-center">
    <h1 style="font-size: 10vw;line-height: 10vw;">
      Not found
    </h1>
    <p style="font-size: 2rem">
      No route found for <code><?php echo htmlspecialchars($requestUri) ?></code>
    </p>
  </div>
</body>

</html>