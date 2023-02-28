<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $this->title ?></title>
  <?php $this->renderSection("head"); ?>
</head>

<body>
  <?php $this->renderBody(); ?>
  <?php //include $bodyScripts; 
  ?>
</body>

</html>