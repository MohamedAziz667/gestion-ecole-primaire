<?php
    session_start();

    require_once('../configuration/connexion.php');

    if (isset($_POST['enregistrer_enseignant'])) {
        $nom_enseignant = $_POST['nom_enseignant'];
        $prenom_enseignant = $_POST['prenom_enseignant'];
        $matricule = $_POST['matricule'];
        $email = $_POST['email'];
        $date_naissance = $_POST['date_naissance'];
        $lieu_naissance = $_POST['lieu_naissance'];
        $grade = $_POST['grade'];
        $telephone = $_POST['telephone'];

        $ancien_tableau = [
                'nom_enseignant' => $nom_enseignant,
                'prenom_enseignant' => $prenom_enseignant,
                'matricule' => $matricule,
                'email' => $email,
                'date_naissance' => $date_naissance,
                'lieu_naissance' => $lieu_naissance,
                'grade' => $grade,
                'telephone' => $telephone
            ];
        
        if(empty($nom_enseignant) || mb_strlen($nom_enseignant) < 2 || empty($prenom_enseignant) || mb_strlen($prenom_enseignant) < 2 || empty($matricule) || mb_strlen($matricule) < 2 || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($date_naissance) || empty($lieu_naissance) || mb_strlen($lieu_naissance) < 2 || empty($grade) || mb_strlen($grade) < 2 || empty($telephone)){
            $_SESSION['message'] = "Veuillez renseigner des informations valides";
            $_SESSION['ancien_formulaire'] = $ancien_tableau;
            $_SESSION['type_message'] = "danger";    
        }else{
            try {
                $rqtVerifEmail = "SELECT ID_enseignant
                                    FROM ENSEIGNANT
                                    WHERE email = ?;";
                $stmtVerifEmail = $connexion->prepare($rqtVerifEmail);
                $stmtVerifEmail->execute([$email]);
                $listeEmail = $stmtVerifEmail->fetch();
    
                $rqtVerifMatricule = "SELECT ID_enseignant
                                    FROM ENSEIGNANT
                                    WHERE matricule = ?;";
                $stmtVerifMatricule = $connexion->prepare($rqtVerifMatricule);
                $stmtVerifMatricule->execute([$matricule]);
                $listeMatricule = $stmtVerifMatricule->fetch();
    
                if($listeEmail != false && $listeMatricule != false){
                    $_SESSION['message'] = "Erreur cet email et cette matricule existent déjà";
                    $_SESSION['ancien_formulaire'] = $ancien_tableau;
                    $_SESSION['type_message'] = "danger";
                }elseif($listeEmail != false){
                    $_SESSION['message'] = "Erreur cet email existe déjà";
                    $_SESSION['ancien_formulaire'] = $ancien_tableau;
                    $_SESSION['type_message'] = "danger";
                }elseif ($listeMatricule != false) {
                    $_SESSION['message'] = "Erreur ce matricule existe déjà";
                    $_SESSION['ancien_formulaire'] = $ancien_tableau;
                    $_SESSION['type_message'] = "danger";
                }else{
                    $rqtInsertEnseignant = "INSERT INTO ENSEIGNANT(nom_enseignant, prenom_enseignant, matricule, email, date_naissance, lieu_naissance, grade, telephone)
                                            VALUES(?, ?, ?, ?, ?, ?, ?, ?);";
                    $stmtInsertEnseignant = $connexion->prepare($rqtInsertEnseignant);
                    $stmtInsertEnseignant->execute([$nom_enseignant, $prenom_enseignant, $matricule, $email, $date_naissance, $lieu_naissance, $grade, $telephone]);
                    $_SESSION['message'] = "Enseignant ajouté avec succès";
                    $_SESSION['type_message'] = "success";
                }
                
            } catch (PDOException $e) {
                $_SESSION['message'] = "Une erreur est survenue lors de l'enregistrement.";
                $_SESSION['type_message'] = "danger";
                $_SESSION['ancien_formulaire'] = $ancien_tableau;
            }
        }
        header("Location: ../enseignants/ajouter.php");
        exit();
    }

?>