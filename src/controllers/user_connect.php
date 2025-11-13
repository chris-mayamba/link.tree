<?php

include_once(__DIR__ . "/../model/user.php");

if (isset($_POST["username"]) && isset( $_POST["password"]) && $_POST > 2) {
    
    $userName = $_POST["username"];
    $userPassword =  $_POST["password"];

    $user[] = null;

    foreach ($user as $users) {
        if ($user["username"] == $userName && $user["password"] == $userPassword) {
         
            echo("OK");
            die;
        }
    }
    echo "OK";

} else {
    echo "Erreur: identifiant invalide";
}

include(__DIR__ . "../model/user.php");