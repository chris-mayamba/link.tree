<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $titles = isset($_POST['title']) ? $_POST['title'] : [] ;
    $urls = isset($_POST['url']) ? $_POST['url'] : [] ;

    $errors = [];

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
            throw new Exception('Le titre du lien ne doit contenir que des espaces.');
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
            throw new Exception('L\'url ne doit contenir que des espaces.');
        }

        if (mb_strlen($url) < 5) {
            throw new Exception("L'url doit contenir au moins 5 caractères.");
        }

}