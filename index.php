<?php
// Simple Router logic

$request_uri = $_SERVER['REQUEST_URI'];
$script_name = dirname($_SERVER['SCRIPT_NAME']);

// Normalize paths
$path = str_replace('\\', '/', $script_name);
if ($path !== '/') {
    $request_path = str_replace($path, '', $request_uri);
} else {
    $request_path = $request_uri;
}
$request_path = trim(parse_url($request_path, PHP_URL_PATH), '/');

// Routing
if (empty($request_path) || $request_path === 'index.php') {
    // HOMEPAGE
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title = "Homepage" ?></title>
  <link rel="stylesheet" href="src/public/style.css">
  <link rel="icon" type="image/x-icon" href="src/assets/favicon.png">
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
<?php
} else {
    // PROFILE PAGE (or other routes)
    // Assume everything else is a username for now
    $username = $request_path;
    
    // Basic sanitization
    $username = htmlspecialchars(strip_tags($username));
    
    // If user types '/login' and we want it to go to login page
    if ($username === 'login') {
         header("Location: src/view/login.php");
         exit;
    }
    
    require 'src/view/profile.php';
}
?>