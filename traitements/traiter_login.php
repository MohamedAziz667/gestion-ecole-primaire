<?php
    session_start(); //Démarre le système de sessions PHP.
    include_once('../configuration/connexion.php'); // Le once évite de l'inclure deux fois si jamais le fichier est appelé plusieurs fois.

    if (isset($_POST['se_connecter'])) {
        $password = $_POST['password'];
        $matricule = trim($_POST['matricule']);

        // prepare() crée une requête préparée sécurisée
        $requette = $connexion->prepare("SELECT U.*, E.nom_enseignant, E.prenom_enseignant, E.matricule 
        FROM UTILISATEUR U
        JOIN ENSEIGNANT E ON E.ID_enseignant = U.fk_id_enseignant
        WHERE E.matricule = :matricule"); // Le :matricule est un placeholder — un emplacement réservé qui sera remplacé par la vraie valeur plus tard. Cela protège contre les injections SQL.
        $requette->bindParam(':matricule', $matricule); // Lie la variable $matricule au placeholder :matricule. PDO se charge de sécuriser la valeur automatiquement.
        $requette->execute(); // Exécute réellement la requête sur la base de données avec la valeur liée.
        $utilisateur = $requette->fetch(PDO::FETCH_ASSOC); //Récupère une seule ligne de résultat sous forme de tableau associatif — c'est à dire qu'on accède aux colonnes par leur nom ($utilisateur['matricule']) plutôt que par leur index numérique.
        
        $pass = password_verify($password, $utilisateur['mot_de_passe']); //Compare le mot de passe saisi avec le hash stocké en base. Cette fonction retourne true ou false.
        if ($utilisateur and $pass) { //On stocke les informations importantes en session pour les utiliser sur toutes les pages
            $_SESSION["ID_connexion"] = $utilisateur["ID_connexion"];
            $_SESSION["role_user"] = $utilisateur["role_user"];
            $_SESSION["fk_id_enseignant"] = $utilisateur["fk_id_enseignant"];
            $_SESSION["matricule"] = $matricule;
            $_SESSION["nom_enseignant"] = $utilisateur["nom_enseignant"];
            header('Location: ../index.php');
            exit();
        }else {
            echo "Utilisateur ou mot de passe incorrect";
        }
    }
?>