<?php
    session_start();
    require_once('../configuration/connexion.php');
    if (isset($_POST["enregistrer_inscription"])) {
        $fk_id_eleve = $_POST['fk_id_eleve'];
        $typeInscription = $_POST['type_inscription'];
        $fk_id_classe = $_POST['fk_id_classe'];
        $fk_id_anneeScolaire = $_POST['fk_id_anneeScolaire'];
        $nom_tuteur = $_POST['nom_tuteur'];
        $telephone_tuteur = $_POST['telephone_tuteur'];

        $rqtVerifClasse = "SELECT Id_classe
                            FROM CLASSE
                            WHERE Id_classe = ?;";
        $stmtVerifClasse = $connexion->prepare($rqtVerifClasse);
        $stmtVerifClasse->execute([$fk_id_classe]);
        $listeClasse = $stmtVerifClasse->fetch();
        if($listeClasse == false){
            $_SESSION['message'] = "Cette classe n'existe pas!";
            header("Location: ../inscriptions/ajouter.php");
            exit();
        }

        $rqtVerifAnnee = "SELECT Id_anneeScolaire
                            FROM ANNEE_SCOLAIRE
                            WHERE Id_anneeScolaire = ?;";
        $stmtVerifAnnee = $connexion->prepare($rqtVerifAnnee);
        $stmtVerifAnnee->execute([$fk_id_anneeScolaire]);
        $listeAnnee = $stmtVerifAnnee->fetch();
        if($listeAnnee == false){
            $_SESSION['message'] = "Cette année scolaire n'existe pas!";
            header("Location: ../inscriptions/ajouter.php");
            exit();
        }

        if ($typeInscription == 'nouveau') {
            $nom_eleve = $_POST['nom_eleve'];
            $prenom_eleve = $_POST['prenom_eleve'];
            $sexe_eleve = $_POST['sexe_eleve'];
            $adresse_eleve = $_POST['adresse_eleve'];
            $date_naissance = $_POST['date_naissance'];
            $lieu_naissance = $_POST['lieu_naissance'];
            if (empty($nom_eleve) || mb_strlen($nom_eleve) < 2 || empty($prenom_eleve) || mb_strlen($prenom_eleve) < 2 || empty($sexe_eleve) || empty($adresse_eleve) || mb_strlen($adresse_eleve) < 2 || empty($date_naissance) || empty($lieu_naissance) || mb_strlen($lieu_naissance) < 2) {
                $_SESSION['message'] = "Les informations saisies sont invalides.";
            }else{
                $connexion->beginTransaction();
                try {
                    $rqtInsertionInscription = "INSERT INTO ELEVE (nom_eleve, prenom_eleve, sexe_eleve, adresse_eleve, date_naissance, lieu_naissance, nom_tuteur, telephone_tuteur)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
                $stmtInsertionInscription = $connexion->prepare($rqtInsertionInscription);
                $stmtInsertionInscription->execute([$nom_eleve, $prenom_eleve, $sexe_eleve, $adresse_eleve, $date_naissance, $lieu_naissance, $nom_tuteur, $telephone_tuteur]);
    
                $fk_id_eleve = $connexion->lastInsertId();
                $rqtMatricule = "UPDATE ELEVE
                SET matricule = CONCAT('ANA-', LPAD(Id_eleve, 6, '0'))
                WHERE Id_eleve = ?;";
                $stmtMatricule = $connexion->prepare($rqtMatricule);
                $stmtMatricule->execute([$fk_id_eleve]);
                $rqtInscription = "INSERT INTO INSCRIPTION (fk_id_eleve, fk_id_classe, fk_id_anneeScolaire)
                                    VALUES (?, ?, ?);";
                $stmtInscription = $connexion->prepare($rqtInscription);
                $stmtInscription->execute([$fk_id_eleve, $fk_id_classe, $fk_id_anneeScolaire]);
                $_SESSION['message'] = "Inscription enregistrée avec succès.";
                $connexion->commit();
                } catch (PDOException $e) {
                    $connexion->rollBack();
                    $_SESSION['message'] = "Une erreur est survenue lors de l'inscription.";
                }
                
            }

        }elseif($typeInscription == 'ancien'){
            $rqtVerifEleve = "SELECT Id_eleve
                            FROM ELEVE
                            WHERE Id_eleve = ?;";
            $stmtVerifEleve = $connexion->prepare($rqtVerifEleve);
            $stmtVerifEleve->execute([$fk_id_eleve]);
            $listeEleve = $stmtVerifEleve->fetch();
            if($listeEleve == false){
                $_SESSION['message'] = "Cet élève n'existe pas!";
                header("Location: ../inscriptions/ajouter.php");
                exit();
            }

            $rqtVerification = "SELECT I.*
                        FROM inscription I
                        WHERE I.fk_id_eleve = ? AND I.fk_id_anneeScolaire = ?";
            $stmtVerification = $connexion->prepare($rqtVerification);
            $stmtVerification->execute([$fk_id_eleve, $fk_id_anneeScolaire]);
            $listeVerification = $stmtVerification->fetch();
            

                if($listeVerification == false){
                    $connexion->beginTransaction();
                    try {
                        $rqtUpdateEleve = "UPDATE ELEVE
                                            SET nom_tuteur = ?, telephone_tuteur = ?
                                            WHERE Id_eleve = ?;";
                        $stmtUpdateEleve = $connexion->prepare($rqtUpdateEleve);
                        $stmtUpdateEleve->execute([$nom_tuteur, $telephone_tuteur, $fk_id_eleve]);
                        $rqtInscription = "INSERT INTO INSCRIPTION (fk_id_eleve, fk_id_classe, fk_id_anneeScolaire)
                                            VALUES (?, ?, ?);";
                        $stmtInscription = $connexion->prepare($rqtInscription);
                        $stmtInscription->execute([$fk_id_eleve, $fk_id_classe, $fk_id_anneeScolaire]);
                        $connexion->commit();
                        $_SESSION['message'] = "Inscription enregistrée avec succès.";
                    } catch (PDOException $e) {
                        $connexion->rollBack();
                        $_SESSION['message'] = "Une erreur est survenue lors de l'inscription.";
                    }
            }else{
                $_SESSION['message'] = "Cet élève est déjà inscrit pour cette année scolaire.";
            }
            
        }
            header("Location: ../inscriptions/ajouter.php");
            exit();
    }
?>