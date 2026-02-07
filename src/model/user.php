<?php
require_once __DIR__ . '/../config.php';

/**
 * Connexion à la base de données
 */
function dbConnect(){
    try {
        return new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    } catch (Exception $e) {
        die('Erreur de connexion : ' . $e->getMessage());
    }
}

/**
 * Inscription : Crée un utilisateur ET sa page par défaut
 */
function create_user(string $username, string $email, string $password): bool
{
    $db = dbConnect();
    try {
        $db->beginTransaction();

        // 1. Insertion de l'utilisateur avec hachage du mot de passe
        $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        $userId = $db->lastInsertId();

        // 2. Création automatique de sa page par défaut
        $stmtPage = $db->prepare("INSERT INTO pages (user_id, title) VALUES (:user_id, :title)");
        $stmtPage->execute([
            'user_id' => $userId,
            'title' => "Page de " . $username
        ]);

        $db->commit();
        return true;
    } catch (Exception $e) {
        if ($db->inTransaction()) {
            $db->rollBack();
        }
        return false;
    }
}

/**
 * Authentification : Vérifie l'email et le mot de passe
 */
function authenticate_user(string $email, string $password): ?array
{
    $db = dbConnect();
    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        unset($user['password']);

        return $user;
    }
    return null;
}
