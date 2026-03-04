<?php
session_start();
require(__DIR__ . "/../model/user.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["username"], $_POST["email"], $_POST["password"]) && 
        !empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
        
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        // Validation stricte
        $error = null;
        if (mb_strlen($username) < 3) {
            $error = "Le pseudo doit contenir au moins 3 caractères.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "L'adresse email n'est pas valide.";
        } elseif (strlen($password) < 6) {
            $error = "Le mot de passe doit contenir au moins 6 caractères.";
        }

        if ($error) {
            $_SESSION['badge'] = [
                'type' => 'danger',
                'message' => $error
            ];
            header("Location: ../view/signUp.php");
            exit;
        }

        if (create_user($username, $email, $password)) {
            // Connexion automatique après inscription
            $user = authenticate_user($email, $password);
            unset($user['password']);
            if ($user) {
                $_SESSION['user'] = $user;
                $_SESSION['badge'] = [
                    'type' => 'success',
                    'message' => 'Bienvenue ! Votre compte a été créé avec succès.'
                ];
                header("Location: ../view/profile.php");
                exit;
            }
        } else {
            $_SESSION['badge'] = [
                'type' => 'danger',
                'message' => 'Erreur lors de la création du compte (email ou pseudo déjà pris).'
            ];
            header("Location: ../view/signUp.php");
            exit;
        }
    } else {
        $_SESSION['badge'] = [
            'type' => 'danger',
            'message' => 'Veuillez remplir tous les champs.'
        ];
        header("Location: ../view/signUp.php");
        exit;
    }
} else {
    header("Location: ../view/signUp.php");
    exit;
}
