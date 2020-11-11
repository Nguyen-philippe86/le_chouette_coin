<?php

    $servername = 'localhost';
    $dbname = 'le_chouette_coin';
    $username = 'root';
    $password = '';
    //On essaie de se connecter
    try {
        $conn = new PDO("mysql:host={$servername};dbname={$dbname}", $username, $password);
        //On définit le mode d'erreur de PDO sur Exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        session_start();
    } catch (PDOException $e) {
        echo 'Erreur : '.$e->getMessage();
    }
    if (isset($_GET['logout'])) {
        session_destroy();
        header('Location: index.php');
    }
