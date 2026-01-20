<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title = "Homepage" ?></title>
  <link rel="stylesheet" href="src/public/style.css">
</head>

<body>
  <div class="bg-animation">
    <div class="blob"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>
  </div>

<?php
  include_once("src/view/home.php");
?>
</body>

</html>