<?php
session_start();

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

    if (trim($bio) === '') {
        throw new Exception('La bio ne peut contenir que des espaces.');
    }
    
    if (mb_strlen($bio) > 500) {
        throw new Exception("La biographie ne doit pas dépasser 500 caractères.");
    }
}