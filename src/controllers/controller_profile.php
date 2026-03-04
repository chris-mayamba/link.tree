<?php
session_start();
require_once __DIR__ . '/../model/user.php';
require_once __DIR__ . '/../model/model_links.php';

// Vérification de la session
if (!isset($_SESSION['user'])) {
    header('Location: ../view/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $job_title = isset($_POST['job_title']) ? trim($_POST['job_title']) : '';
    $bio = isset($_POST['bio']) ? trim($_POST['bio']) : '';

    $errors = [];

    // Validation du Profil
    try {
        if ($job_title === null || $job_title === '') {
            throw new Exception('Ce champ ne doit pas être vide.');
        }
        if (trim($job_title) === '') {
            throw new Exception('Ce champ ne peut contenir que des espaces.');
        }
        if (mb_strlen($job_title) > 100) {
            throw new Exception("Le titre du métier ne doit pas dépasser 100 caractères.");
        }
    } catch (Exception $e) {
        $errors['job_title'] = $e->getMessage();
    }

    try {
        if (mb_strlen($bio) > 500) {
            throw new Exception("La biographie ne doit pas dépasser 500 caractères.");
        }
    } catch (Exception $e) {
        $errors['bio'] = $e->getMessage();
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: ../view/profile/profile.php');
        exit;
    }
    
    // 1. Récupérer la page de l'utilisateur
    $userId = $_SESSION['user']['id'];
    $page = get_page_by_user_id($userId);

    if (!$page) {
        die("Erreur : Page utilisateur introuvable.");
    }
    $pageId = $page['id'];

    // Gestion de l'upload d'image de profil (si vous avez cette fonction, sinon on met juste à jour métier/bio)
    // upload_profile_picture... (à implémenter ultérieurement si nécessaire, on garde juste job_title/bio pour l'instant)

    // 2. Mise à jour des infos de la page (Bio, Métier)
    update_page_info($pageId, $job_title, $bio);

    $_SESSION['success'] = "Profil mis à jour avec succès !";
    header('Location: ../view/profile/profile.php');
    exit;

} else {
    header('Location: ../view/profile/profile.php');
    exit;
}
