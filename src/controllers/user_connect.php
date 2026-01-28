<?php

require(__DIR__ . "/../model/user.php");

try {
    if (!isset($_POST["usernane"]) || !isset($_POST["password"])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        find_user($username, $password);

        header("Location: ../view/dashboard.php");
    }
} catch (Exception $e) {
    throw new Exception("");
}
