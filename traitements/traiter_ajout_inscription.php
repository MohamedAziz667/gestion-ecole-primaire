<?php
    require_once('../configuration/connexion.php');
    if (isset($_POST["enregistrer_inscription"])) {
        $nom_eleve = $_POST['nom_eleve'];
        $prenom_eleve = $_POST['prenom_eleve'];
        $sexe_eleve = $_POST['sexe_eleve'];
        $adresse_eleve = $_POST['adresse_eleve'];
        $date_naissance = $_POST['date_naissance'];
    }
?>