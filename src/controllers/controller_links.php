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
    
    $titles = isset($_POST['title']) ? $_POST['title'] : [] ;
    $urls = isset($_POST['url']) ? $_POST['url'] : [] ;
    $icons = isset($_POST['icon']) ? $_POST['icon'] : [] ;

    $errors = [];

    // Validation des Liens
    foreach($titles as $key => $title) {
        try {
            validateTitle($title);
        } catch (Exception $e) {
            $errors['title'][$key] = $e->getMessage();
        }
    }

    foreach($urls as $key => $url) {
        // Normalisation URL : Ajout du protocole si manquant (https par défaut)
        if (!empty($url) && !preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "https://" . $url;
            $urls[$key] = $url; // Mise à jour du tableau pour l'enregistrement
        }
        
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

    // 3. Ajout des NOUVEAUX liens uniquement (on ne supprime plus les anciens !)
    // On récupère le plus grand numéro d'ordre actuel pour ajouter à la suite
    $db = dbConnect();
    
    // Obtenir la position max actuelle
    $stmt = $db->prepare('SELECT MAX(position) FROM links WHERE page_id = ?');
    $stmt->execute([$pageId]);
    $maxPosition = $stmt->fetchColumn();
    $startingPosition = $maxPosition !== null ? $maxPosition + 1 : 0;

    try {
        $db->beginTransaction();

        // Insertion des NOUVEAUX liens valides
        foreach ($titles as $key => $titleItem) {
            $urlItem = $urls[$key] ?? '';
            $iconItem = !empty($icons[$key]) ? $icons[$key] : null;   
            
            // On ignore les entrées complètement vides
            if(trim($titleItem) !== '' && trim($urlItem) !== '') {
                // On passe $startingPosition + $key pour définir l'ordre d'affichage
                create_link($pageId, $titleItem, $urlItem, $iconItem, $startingPosition + $key, $db); 
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

    // met la condition pour verifier si l'url commence avec  https:\\    
    if($url && !preg_match("~^(?:f|ht)tps?://~i", $url)){
        throw new Exception("L'url doit commencer par http:// ou https://");
    }

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
