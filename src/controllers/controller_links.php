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
    
    $titles = isset($_POST['title']) ? $_POST['title'] : [] ;
    $urls = isset($_POST['url']) ? $_POST['url'] : [] ;
    $icons = isset($_POST['icon']) ? $_POST['icon'] : [] ;

    $errors = [];

    // Validation du Profil
    try {
        validateJobTitle($job_title);
    } catch (Exception $e) {
        $errors['job_title'] = $e->getMessage();
    }

    try {
        validateBio($bio);
    } catch (Exception $e) {
        $errors['bio'] = $e->getMessage();
    }

    // Validation des Liens
    foreach($titles as $key => $title) {
        try {
            validateTitle($title);
        } catch (Exception $e) {
            $errors['title'][$key] = $e->getMessage();
        }
    }

    foreach($urls as $key => $url) {
        try {
            validateUrl($url);
        } catch (Exception $e) {
            $errors['url'][$key] = $e->getMessage();
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old_inputs'] = $_POST;
        header('Location: ../view/links/create.php');
        exit;
    }
    // 1. Récupérer la page de l'utilisateur
    $userId = $_SESSION['user']['id'];
    $page = get_page_by_user_id($userId);

    if (!$page) {
        
        die("Erreur : Page utilisateur introuvable.");
    }
    $pageId = $page['id'];

    // 2. Mise à jour des infos de la page (Bio, Métier)
    update_page_info($pageId, $job_title, $bio);

    // 3. Mise à jour des liens (Suppression totale puis recréation)
    // On utilise une transaction ppoour éviter les états incohérents
    $db = dbConnect();
    try {
        $db->beginTransaction();

        delete_links_by_page_id($pageId, $db);

        // Réinsertion des liens valides
        foreach ($titles as $key => $titleItem) {
            $urlItem = $urls[$key] ?? '';
            $iconItem = !empty($icons[$key]) ? $icons[$key] : null;   
            
            // On ignore les entrées vides si jamais il y en a qui sont passées
            if(trim($titleItem) !== '' && trim($urlItem) !== '') {
                create_link($pageId, $titleItem, $urlItem, $iconItem, $key, $db); // $key sert de position
            }
        }

        $db->commit();

    } catch (Exception $e) {
        $db->rollBack();
        $_SESSION['errors']['global'] = "Erreur système : " . $e->getMessage();
        $_SESSION['old_inputs'] = $_POST;
        header('Location: ../view/links/create.php');
        exit;
    }

    // Succès -> Redirection vers la liste des liens ou profile
    $_SESSION['badge'] = [
        'type' => 'success',
        'message' => 'Profil mis à jour avec succès !'
    ];
    header('Location: ../view/links.php'); // Ou links.php selon votre flux
    exit;
}

function validateTitle($title){
        
        if ($title === null || $title === '') {
            throw new Exception('Le titre du lien ne doit pas être vide.');
        }

        if (trim($title) === '') {
            throw new Exception('Le titre du lien ne peut contenir que des espaces.');
        }

        if (mb_strlen($title) < 3) {
            throw new Exception("Le titre du lien doit contenir au moins 3 caractères.");
        }

}

function validateUrl($url){
    
    if ($url === null || $url === '') {
        throw new Exception('L\'url ne doit pas être vide.');
    }

    if (trim($url) === '') {
        throw new Exception('L\'url ne peut contenir que des espaces.');
    }

    if (mb_strlen($url) < 5) {
        throw new Exception("L'url doit contenir au moins 5 caractères.");
    }

}

function validateJobTitle($job_title) {
            
    if ($job_title === null || $job_title === '') {
        throw new Exception('Ce champ ne doit pas être vide.');
    }

    if (trim($job_title) === '') {
        throw new Exception('Ce champ ne peut contenir que des espaces.');
    }
    
    if (mb_strlen($job_title) > 100) {
        throw new Exception("Le titre du métier ne doit pas dépasser 100 caractères.");
    }
}

function validateBio($bio) {        
    
    if (mb_strlen($bio) > 500) {
        throw new Exception("La biographie ne doit pas dépasser 500 caractères.");
    }
}