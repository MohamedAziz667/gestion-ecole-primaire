
<?php

session_start();
require_once('../configuration/connexion.php');

/*
|--------------------------------------------------------------------------
| 1. Vérifier que le formulaire a été soumis
|--------------------------------------------------------------------------
| Le traitement ne doit être exécuté que si le bouton
| "enregistrer_inscription" a été envoyé.
*/
if (isset($_POST['enregistrer_inscription'])) {

    /*
    |--------------------------------------------------------------------------
    | 2. Récupérer les champs communs aux deux types d'inscription
    |--------------------------------------------------------------------------
    | Ces champs existent aussi bien pour un nouvel élève
    | que pour un ancien élève.
    */
    $fk_id_eleve = trim($_POST['fk_id_eleve'] ?? '');
    $type_inscription = trim($_POST['type_inscription'] ?? '');
    $fk_id_classe = trim($_POST['fk_id_classe'] ?? '');
    $fk_id_anneeScolaire = trim($_POST['fk_id_anneeScolaire'] ?? '');
    $nom_tuteur = trim($_POST['nom_tuteur'] ?? '');
    $telephone_tuteur = trim($_POST['telephone_tuteur'] ?? '');

    /*
    |--------------------------------------------------------------------------
    | 3. Préparer les données à conserver dans la session
    |--------------------------------------------------------------------------
    | Si une erreur survient, le formulaire sera réaffiché après
    | une redirection. La session permettra de retrouver les valeurs.
    */
    if ($type_inscription === 'nouveau') {

        // Récupérer les informations personnelles du nouvel élève.
        $nom_eleve = trim($_POST['nom_eleve'] ?? '');
        $prenom_eleve = trim($_POST['prenom_eleve'] ?? '');
        $sexe_eleve = trim($_POST['sexe_eleve'] ?? '');
        $adresse_eleve = trim($_POST['adresse_eleve'] ?? '');
        $date_naissance = trim($_POST['date_naissance'] ?? '');
        $lieu_naissance = trim($_POST['lieu_naissance'] ?? '');

        // Regrouper toutes les valeurs dans un tableau associatif.
        $ancien_tableau = [
            'nom_eleve' => $nom_eleve,
            'prenom_eleve' => $prenom_eleve,
            'sexe_eleve' => $sexe_eleve,
            'adresse_eleve' => $adresse_eleve,
            'date_naissance' => $date_naissance,
            'lieu_naissance' => $lieu_naissance,
            'nom_tuteur' => $nom_tuteur,
            'telephone_tuteur' => $telephone_tuteur,
            'fk_id_classe' => $fk_id_classe,
            'fk_id_anneeScolaire' => $fk_id_anneeScolaire,
            'type_inscription' => $type_inscription
        ];

        // Sauvegarder les données pour les retrouver en cas d'erreur.
        $_SESSION['ancien_formulaire'] = $ancien_tableau;

    } elseif ($type_inscription === 'ancien') {

        // Pour un ancien élève, conserver ses identifiants
        // et les autres valeurs saisies dans le formulaire.
        $_SESSION['ancien_formulaire'] = [
            'fk_id_eleve' => $fk_id_eleve,
            'type_inscription' => $type_inscription,
            'fk_id_classe' => $fk_id_classe,
            'fk_id_anneeScolaire' => $fk_id_anneeScolaire,
            'nom_tuteur' => $nom_tuteur,
            'telephone_tuteur' => $telephone_tuteur
        ];

    } else {

        // Refuser un type d'inscription qui n'est pas prévu.
        $_SESSION['message'] = "Veuillez choisir un type d'inscription.";
        $_SESSION['type_message'] = 'danger';

        header('Location: ../inscriptions/ajouter.php');
        exit();
    }

    /*
    |--------------------------------------------------------------------------
    | 4. Vérifier que la classe existe
    |--------------------------------------------------------------------------
    | Cette vérification est commune aux deux types d'inscription.
    */
    if ($fk_id_classe === '') {

        $_SESSION['message'] = "Veuillez choisir une classe.";
        $_SESSION['type_message'] = 'danger';

        header('Location: ../inscriptions/ajouter.php');
        exit();
    }

    $rqtVerifClasse = "SELECT Id_classe
                       FROM CLASSE
                       WHERE Id_classe = ?";

    $stmtVerifClasse = $connexion->prepare($rqtVerifClasse);
    $stmtVerifClasse->execute([$fk_id_classe]);

    $listeClasse = $stmtVerifClasse->fetch();

    if ($listeClasse === false) {

        $_SESSION['message'] = "La classe sélectionnée n'existe pas.";
        $_SESSION['type_message'] = 'danger';

        header('Location: ../inscriptions/ajouter.php');
        exit();
    }

    /*
    |--------------------------------------------------------------------------
    | 5. Vérifier que l'année scolaire existe
    |--------------------------------------------------------------------------
    | Cette vérification est également commune aux deux types.
    */
    if ($fk_id_anneeScolaire === '') {

        $_SESSION['message'] = "Veuillez choisir une année scolaire.";
        $_SESSION['type_message'] = 'danger';

        header('Location: ../inscriptions/ajouter.php');
        exit();
    }

    $rqtVerifAnnee = "SELECT Id_anneeScolaire
                      FROM ANNEE_SCOLAIRE
                      WHERE Id_anneeScolaire = ?";

    $stmtVerifAnnee = $connexion->prepare($rqtVerifAnnee);
    $stmtVerifAnnee->execute([$fk_id_anneeScolaire]);

    $listeAnnee = $stmtVerifAnnee->fetch();

    if ($listeAnnee === false) {

        $_SESSION['message'] = "L'année scolaire sélectionnée n'existe pas.";
        $_SESSION['type_message'] = 'danger';

        header('Location: ../inscriptions/ajouter.php');
        exit();
    }

    /*
    |--------------------------------------------------------------------------
    | 6. TRAITEMENT D'UN NOUVEL ÉLÈVE
    |--------------------------------------------------------------------------
    | Nous validons les informations personnelles avant de commencer
    | une transaction et d'insérer des données dans la base.
    */
    if ($type_inscription === 'nouveau') {

        // Validation du nom.
        if (empty($nom_eleve) || mb_strlen($nom_eleve) < 2) {

            $_SESSION['message'] = "Le nom doit contenir au moins 2 caractères.";
            $_SESSION['type_message'] = 'danger';

        // Validation du prénom.
        } elseif (empty($prenom_eleve) || mb_strlen($prenom_eleve) < 2) {

            $_SESSION['message'] = "Le prénom doit contenir au moins 2 caractères.";
            $_SESSION['type_message'] = 'danger';

        // Validation du sexe.
        } elseif (!in_array($sexe_eleve, ['M', 'F'], true)) {

            $_SESSION['message'] = "Veuillez choisir un sexe valide.";
            $_SESSION['type_message'] = 'danger';

        // Validation de l'adresse.
        } elseif (empty($adresse_eleve) || mb_strlen($adresse_eleve) < 2) {

            $_SESSION['message'] = "L'adresse doit contenir au moins 2 caractères.";
            $_SESSION['type_message'] = 'danger';

        // Validation de la date de naissance.
        } elseif (empty($date_naissance)) {

            $_SESSION['message'] = "La date de naissance est obligatoire.";
            $_SESSION['type_message'] = 'danger';

        // Validation du lieu de naissance.
        } elseif (empty($lieu_naissance) || mb_strlen($lieu_naissance) < 2) {

            $_SESSION['message'] = "Le lieu de naissance doit contenir au moins 2 caractères.";
            $_SESSION['type_message'] = 'danger';

        } else {

            /*
             * Toutes les validations sont réussies.
             * La transaction garantit que la création de l'élève
             * et son inscription sont réalisées ensemble.
             */
            try {

                $connexion->beginTransaction();

                // 1. Insérer le nouvel élève.
                $rqtInsertionEleve = "INSERT INTO ELEVE
                    (nom_eleve, prenom_eleve, sexe_eleve, adresse_eleve,
                     date_naissance, lieu_naissance, nom_tuteur, telephone_tuteur)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                $stmtInsertionEleve = $connexion->prepare($rqtInsertionEleve);

                $stmtInsertionEleve->execute([
                    $nom_eleve,
                    $prenom_eleve,
                    $sexe_eleve,
                    $adresse_eleve,
                    $date_naissance,
                    $lieu_naissance,
                    $nom_tuteur,
                    $telephone_tuteur
                ]);

                // 2. Récupérer l'identifiant généré par la base.
                $fk_id_eleve = $connexion->lastInsertId();

                // 3. Générer le matricule à partir de cet identifiant.
                $rqtMatricule = "UPDATE ELEVE
                    SET matricule = CONCAT('ANA-', LPAD(Id_eleve, 6, '0'))
                    WHERE Id_eleve = ?";

                $stmtMatricule = $connexion->prepare($rqtMatricule);
                $stmtMatricule->execute([$fk_id_eleve]);

                // 4. Inscrire le nouvel élève dans la classe et l'année choisies.
                $rqtInscription = "INSERT INTO INSCRIPTION
                    (fk_id_eleve, fk_id_classe, fk_id_anneeScolaire)
                    VALUES (?, ?, ?)";

                $stmtInscription = $connexion->prepare($rqtInscription);

                $stmtInscription->execute([
                    $fk_id_eleve,
                    $fk_id_classe,
                    $fk_id_anneeScolaire
                ]);

                // Valider définitivement les deux insertions et le matricule.
                $connexion->commit();

                $_SESSION['message'] = "Inscription enregistrée avec succès.";
                $_SESSION['type_message'] = 'success';

                // Le formulaire est réinitialisé après une réussite.
                unset($_SESSION['ancien_formulaire']);

            } catch (PDOException $e) {

                // Annuler les changements si une requête échoue.
                if ($connexion->inTransaction()) {
                    $connexion->rollBack();
                }

                // En production, enregistrer les détails dans un journal
                // plutôt que de les afficher directement à l'utilisateur.
                error_log($e->getMessage());

                $_SESSION['message'] = "Une erreur est survenue lors de l'inscription.";
                $_SESSION['type_message'] = 'danger';
            }
        }

    /*
    |--------------------------------------------------------------------------
    | 7. TRAITEMENT D'UN ANCIEN ÉLÈVE
    |--------------------------------------------------------------------------
    | L'élève existe déjà dans ELEVE : nous vérifions son identifiant,
    | puis nous contrôlons qu'il n'est pas déjà inscrit pour cette année.
    */
    } elseif ($type_inscription === 'ancien') {

        // Un ancien élève doit être sélectionné.
        if ($fk_id_eleve === '') {

            $_SESSION['message'] = "Veuillez sélectionner un élève.";
            $_SESSION['type_message'] = 'danger';

        } else {

            // Vérifier que l'identifiant correspond à un élève existant.
            $rqtVerifEleve = "SELECT Id_eleve
                              FROM ELEVE
                              WHERE Id_eleve = ?";

            $stmtVerifEleve = $connexion->prepare($rqtVerifEleve);
            $stmtVerifEleve->execute([$fk_id_eleve]);

            $listeEleve = $stmtVerifEleve->fetch();

            if ($listeEleve === false) {

                $_SESSION['message'] = "Cet élève n'existe pas.";
                $_SESSION['type_message'] = 'danger';

            } else {

                // Vérifier si cet élève possède déjà une inscription
                // pour l'année scolaire choisie, quelle que soit sa classe.
                $rqtVerification = "SELECT 1
                                    FROM INSCRIPTION
                                    WHERE fk_id_eleve = ?
                                      AND fk_id_anneeScolaire = ?
                                    LIMIT 1";

                $stmtVerification = $connexion->prepare($rqtVerification);

                $stmtVerification->execute([
                    $fk_id_eleve,
                    $fk_id_anneeScolaire
                ]);

                $listeVerification = $stmtVerification->fetch();

                if ($listeVerification !== false) {

                    $_SESSION['message'] = "Cet élève est déjà inscrit pour cette année scolaire.";
                    $_SESSION['type_message'] = 'danger';

                } else {

                    // Aucune inscription pour cette année :
                    // mettre à jour le tuteur et créer l'inscription.
                    try {

                        $connexion->beginTransaction();

                        $rqtUpdateEleve = "UPDATE ELEVE
                            SET nom_tuteur = ?, telephone_tuteur = ?
                            WHERE Id_eleve = ?";

                        $stmtUpdateEleve = $connexion->prepare($rqtUpdateEleve);

                        $stmtUpdateEleve->execute([
                            $nom_tuteur,
                            $telephone_tuteur,
                            $fk_id_eleve
                        ]);

                        $rqtInscription = "INSERT INTO INSCRIPTION
                            (fk_id_eleve, fk_id_classe, fk_id_anneeScolaire)
                            VALUES (?, ?, ?)";

                        $stmtInscription = $connexion->prepare($rqtInscription);

                        $stmtInscription->execute([
                            $fk_id_eleve,
                            $fk_id_classe,
                            $fk_id_anneeScolaire
                        ]);

                        $connexion->commit();

                        $_SESSION['message'] = "Inscription enregistrée avec succès.";
                        $_SESSION['type_message'] = 'success';

                        // Réinitialiser le formulaire après la réussite.
                        unset($_SESSION['ancien_formulaire']);

                    } catch (PDOException $e) {

                        if ($connexion->inTransaction()) {
                            $connexion->rollBack();
                        }

                        error_log($e->getMessage());

                        $_SESSION['message'] = "Une erreur est survenue lors de l'inscription.";
                        $_SESSION['type_message'] = 'danger';
                    }
                }
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | 8. REDIRECTION FINALE
    |--------------------------------------------------------------------------
    | Le navigateur revient sur le formulaire.
    | La page ajouter.php pourra afficher le message de session
    | et restaurer les valeurs si l'inscription a échoué.
    */
    header('Location: ../inscriptions/ajouter.php');
    exit();
}
?>
