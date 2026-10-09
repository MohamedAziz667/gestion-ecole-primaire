<?php
    session_start();
    require_once('../configuration/connexion.php');
    $modification_reussie = false;

    if (isset($_POST['modifier_enseignant'])) {
        $id_enseignant = $_POST['id_enseignant'];
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
        if(empty($nom_enseignant) || mb_strlen($nom_enseignant) < 2){
            $_SESSION['message'] = "Le nom doit contenir au moins 2 caractères.";
            $_SESSION['ancien_formulaire'] = $ancien_tableau;
            $_SESSION['type_message'] = "danger";    
        }elseif(!preg_match('/^[0-9]{9}$/', $telephone)){
            $_SESSION['message'] = "Veuillez saisir un numéro valide";
            $_SESSION['ancien_formulaire'] = $ancien_tableau;
            $_SESSION['type_message'] = "danger";   
        }elseif(empty($prenom_enseignant) || mb_strlen($prenom_enseignant) < 2){
            $_SESSION['message'] = "Le prénom doit contenir au moins 2 caractères.";
            $_SESSION['ancien_formulaire'] = $ancien_tableau;
            $_SESSION['type_message'] = "danger";       
        }elseif(empty($matricule) || mb_strlen($matricule) < 2){
            $_SESSION['message'] = "Le matricule doit contenir au moins 2 caractères.";
            $_SESSION['ancien_formulaire'] = $ancien_tableau;
            $_SESSION['type_message'] = "danger";       
        }elseif(empty($lieu_naissance) || mb_strlen($lieu_naissance) < 2){
            $_SESSION['message'] = "Le lieu de naissance doit contenir au moins 2 caractères.";
            $_SESSION['ancien_formulaire'] = $ancien_tableau;
            $_SESSION['type_message'] = "danger";       
        }elseif(empty($grade) || mb_strlen($grade) < 2){
            $_SESSION['message'] = "Le grade doit contenir au moins 2 caractères.";
            $_SESSION['ancien_formulaire'] = $ancien_tableau;
            $_SESSION['type_message'] = "danger";       
        }elseif(empty($date_naissance)){
            $_SESSION['message'] = "Veuillez renseigner une date de naissance.";
            $_SESSION['ancien_formulaire'] = $ancien_tableau;
            $_SESSION['type_message'] = "danger";       
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['message'] = "Cet email est invalide.";
            $_SESSION['ancien_formulaire'] = $ancien_tableau;
            $_SESSION['type_message'] = "danger";       
        }
        else{
            try {
                $rqtVerifEmail = "SELECT ID_enseignant
                                    FROM ENSEIGNANT
                                    WHERE email = ? AND ID_enseignant != ?;";
                $stmtVerifEmail = $connexion->prepare($rqtVerifEmail);
                $stmtVerifEmail->execute([$email, $id_enseignant]);
                $listeEmail = $stmtVerifEmail->fetch();
    
                $rqtVerifMatricule = "SELECT ID_enseignant
                                    FROM ENSEIGNANT
                                    WHERE matricule = ? AND ID_enseignant != ?;";
                $stmtVerifMatricule = $connexion->prepare($rqtVerifMatricule);
                $stmtVerifMatricule->execute([$matricule, $id_enseignant]);
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
                    $rqtInsertEnseignant = "UPDATE ENSEIGNANT SET nom_enseignant = ?, prenom_enseignant = ?, matricule = ?, email = ?, date_naissance = ?, lieu_naissance = ?, grade = ?, telephone = ? WHERE ID_enseignant = ?;";
                    $stmtInsertEnseignant = $connexion->prepare($rqtInsertEnseignant);
                    $stmtInsertEnseignant->execute([$nom_enseignant, $prenom_enseignant, $matricule, $email, $date_naissance, $lieu_naissance, $grade, $telephone, $id_enseignant]);
                    $_SESSION['message'] = "Enseignant modifié avec succès";
                    $_SESSION['type_message'] = "success";
                    $modification_reussie = true;
                }
                
            } catch (PDOException $e) {
                $_SESSION['message'] = "Une erreur est survenue lors de la modification.";
                $_SESSION['type_message'] = "danger";
                $_SESSION['ancien_formulaire'] = $ancien_tableau;
            }
        }
        if($modification_reussie === true){
            header("Location: ../enseignants/liste.php");
            exit();
        }else{
            header("Location: ../enseignants/modifier.php?id=" . $id_enseignant);
            exit();
        }
    }
?>