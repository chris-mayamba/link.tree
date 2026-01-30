<?php
session_start();
require(__DIR__ . "/../model/user.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["username"]) && isset($_POST["password"]) && !empty($_POST["username"]) && !empty($_POST["password"])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user = find_user($username, $password);

        if ($user) {
            $_SESSION['flash'] = [
                'type' => 'success',
                'message' => 'Connexion réussie !'
            ];
            header("Location: ../view/dashboard.php");
            exit;
        } else {
            $_SESSION['flash'] = [
                'type' => 'danger',
                'message' => 'Identifiants incorrects.'
            ];
            header("Location: ../view/login.php");
            exit;
        }
    } else {
        $_SESSION['flash'] = [
            'type' => 'danger',
            'message' => 'Veuillez remplir tous les champs.'
        ];
        header("Location: ../view/login.php");
        exit;
    }
} else {
    // Si on accède au contrôleur sans POST, redirection vers login
    header("Location: ../view/login.php");
    exit;
}
