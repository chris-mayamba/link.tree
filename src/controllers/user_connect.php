<?php
session_start();
require(__DIR__ . "/../model/user.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["email"]) && isset($_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = authenticate_user($email, $password);
        
        unset($user['password']);

        if ($user) {
            // Store minimal user info in session to mark as authenticated
            $_SESSION['user'] = $user;
            $_SESSION['badge'] = [
                'type' => 'success',
                'message' => 'Connexion réussie !'
            ];
            header("Location: ../view/profile.php");
            exit;
        } else {
            $_SESSION['badge'] = [
                'type' => 'danger',
                'message' => 'Identifiants incorrects.'
            ];
            header("Location: ../view/login.php");
            exit;
        }
    } else {
        $_SESSION['badge'] = [
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
