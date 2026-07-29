<?php
    session_start();
    if (!(isset($_SESSION["ID_connexion"]))) {
        header('Location: /Gestion_Ecole_Primaire/auth/login.php');
        exit();
    }
?>