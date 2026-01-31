<?php

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        session_start();
        session_unset();
        session_destroy();

        // Use a web-accessible path (not filesystem path) to avoid unsafe redirects in browser
        header("Location: /index.php");
        exit();
    }