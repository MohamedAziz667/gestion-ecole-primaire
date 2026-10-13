<?php
    session_start();

    require_once('../configuration/connexion.php');

    if (isset($_POST['enregistrer_enseignant'])) {
        $nom_enseignant = trim($_POST['nom_enseignant'] ?? '');
        $prenom_enseignant = trim($_POST['prenom_enseignant'] ?? '');
        $matricule = trim($_POST['matricule'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $date_naissance = $_POST['date_naissance'] ?? '';
        $lieu_naissance = trim($_POST['lieu_naissance'] ?? '');
        $grade = trim($_POST['grade'] ?? '');
        $telephone = trim($_POST['telephone'] ?? '');
        $fonction = trim($_POST['fonction'] ?? '');
        $statut = trim($_POST['statut'] ?? '');

        $ancien_tableau = [
                'nom_enseignant' => $nom_enseignant,
                'prenom_enseignant' => $prenom_enseignant,
                'matricule' => $matricule,
                'email' => $email,
                'date_naissance' => $date_naissance,
                'lieu_naissance' => $lieu_naissance,
                'grade' => $grade,
                'telephone' => $telephone,
                'fonction' => $fonction,
                'statut' => $statut
            ];
        
        if(empty($nom_enseignant) || mb_strlen($nom_enseignant) < 2){
            $_SESSION['message'] = "Le nom doit contenir au moins 2 caractères.";
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
        }elseif(empty($date_naissance)){
            $_SESSION['message'] = "Veuillez renseigner une date de naissance.";
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
        }elseif(!preg_match('/^[0-9]{9}$/', $telephone)){
            $_SESSION['message'] = "Veuillez saisir un numéro valide";
            $_SESSION['ancien_formulaire'] = $ancien_tableau;
            $_SESSION['type_message'] = "danger"; 
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['message'] = "Cet email est invalide.";
            $_SESSION['ancien_formulaire'] = $ancien_tableau;
            $_SESSION['type_message'] = "danger"; 
        }elseif(empty($statut)){
            $_SESSION['message'] = "Le statut est obligatoire.";
            $_SESSION['ancien_formulaire'] = $ancien_tableau;
            $_SESSION['type_message'] = "danger"; 
        }elseif(empty($fonction)){
            $_SESSION['message'] = "La fonction est obligatoire.";
            $_SESSION['ancien_formulaire'] = $ancien_tableau;
            $_SESSION['type_message'] = "danger"; 
        }
        else{
            try {
                $rqtVerifFonction = "SELECT ID_enseignant
                                    FROM ENSEIGNANT
                                    WHERE fonction = 'direction';";
                $stmtVerifFonction = $connexion->prepare($rqtVerifFonction);
                $stmtVerifFonction->execute();
                $listeFonction = $stmtVerifFonction->fetch();

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
                }elseif($listeFonction != false && $fonction === 'direction'){
                    $_SESSION['message'] = "La fonction pour la direction a déjà été attribuée.";
                    $_SESSION['ancien_formulaire'] = $ancien_tableau;
                    $_SESSION['type_message'] = "danger";
                }else{
                    $rqtInsertEnseignant = "INSERT INTO ENSEIGNANT(nom_enseignant, prenom_enseignant, matricule, email, date_naissance, lieu_naissance, grade, telephone, fonction, statut)
                                            VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
                    $stmtInsertEnseignant = $connexion->prepare($rqtInsertEnseignant);
                    $stmtInsertEnseignant->execute([$nom_enseignant, $prenom_enseignant, $matricule, $email, $date_naissance, $lieu_naissance, $grade, $telephone, $fonction, $statut]);
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