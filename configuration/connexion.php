<?php
    $username = "root";
    $servername = "localhost";
    $password = "";
    $bd_name = "ecole_primaire_ana";

    try{
        $connexion = new PDO("mysql:host=$servername;dbname=$bd_name",$username,$password);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo 'Connexion réussi';
    } catch (PDOException $mess){
        echo "Echec Connexion" . $mess->getMessage();
        die();
    }
?>