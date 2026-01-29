<?php

require(__DIR__ . "/../model/user.php");

if (isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = find_user($username, $password);

    if ($user) {
        // Utilisateur trouvé, rediriger vers le dashboard
        header("Location: ../view/dashboard.php");
        exit;
    } else {
        // Identifiants incorrects
        header("Location: ../view/login.php?error=1");
        exit;
    }
} else {
    // Champs manquants
    header("Location: ../view/login.php?error=2");
    exit;
}
