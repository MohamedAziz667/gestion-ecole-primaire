<?php
    include_once('../includes/auth_check.php');
    include_once('../configuration/connexion.php');

    $id = $_GET['id'] ?? '';
    if (!filter_var($id, FILTER_VALIDATE_INT) || $id <= 0) {
        $_SESSION['message'] = "Identifiant invalide.";
        $_SESSION['type_message'] = "danger";
        header("Location: liste.php");
        exit();
    }
        $id = (int) $id;
         $rqtEleve = "SELECT E.nom_eleve, E.prenom_eleve, E.matricule, E.sexe_eleve, E.date_naissance, E.lieu_naissance, E.adresse_eleve, E.nom_tuteur, E.telephone_tuteur
                    FROM ELEVE E
                    WHERE E.Id_eleve = ?;";
        $stmtEleve = $connexion->prepare($rqtEleve);
        $stmtEleve->execute([$id]);
        $eleve = $stmtEleve->fetch(PDO::FETCH_ASSOC);
        if ($eleve === false) {
            $_SESSION['message'] = "L'élève n'existe pas.";
            $_SESSION['type_message'] = "danger";
            header("Location: liste.php");
            exit();
        }
            $rqtRecupEleve = "SELECT I.statut, A.annee, C.nom_classe
                            FROM INSCRIPTION I
                            JOIN CLASSE C ON I.fk_id_classe = C.Id_classe
                            JOIN ANNEE_SCOLAIRE A ON I.fk_id_anneeScolaire = A.Id_anneeScolaire
                            WHERE I.fk_id_eleve = ?
                            ORDER BY A.annee ASC;";
            $stmtRecupEleve = $connexion->prepare($rqtRecupEleve);
            $stmtRecupEleve->execute([$id]);
            $recupEleve = $stmtRecupEleve->fetchAll(PDO::FETCH_ASSOC);

            if (empty($recupEleve)) {
                 $_SESSION['message'] = "Aucun historique d'inscription n'est disponible pour cet élève.";
                $_SESSION['type_message'] = "warning";
            }
                $rqtInscriptionActive = "SELECT I.statut, A.annee, C.nom_classe
                                        FROM INSCRIPTION I
                                        JOIN CLASSE C ON I.fk_id_classe = C.Id_classe
                                        JOIN ANNEE_SCOLAIRE A ON I.fk_id_anneeScolaire = A.Id_anneeScolaire
                                        WHERE I.fk_id_eleve = ? AND A.statut = 'active';";
                        $stmtInscriptionActive = $connexion->prepare($rqtInscriptionActive);
                        $stmtInscriptionActive->execute([$id]);
                        $inscriptionActive = $stmtInscriptionActive->fetch(PDO::FETCH_ASSOC);
            

    include_once('../includes/header.php');
    include_once('../includes/navbar.php');
    include_once('../includes/sidebar.php');

?>


<div class="container-fluid px-4">

   <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 mb-4">
        <h3 class="fw-bold mb-0">FICHE INDIVIDUELLE DE L'ÉLÈVE</h3>

        <div class="d-flex gap-2 mt-3 mt-md-0">
            <button type="button" onclick="window.print()"
                    class="btn btn-outline-primary rounded-pill px-3">
                <i class="fas fa-print me-2"></i> Imprimer
            </button>

            <a href="liste.php"
               class="btn btn-outline-secondary rounded-pill px-3">
                <i class="fas fa-arrow-left me-2"></i> Retour
            </a>
        </div>
    </div>

    <!-- Carte principale -->
    <div class="card border-0 shadow-sm mb-4 overflow-hidden">

        <!-- Identité de l'établissement et de l'élève -->
        <div class="bg-primary text-white p-4">

            <div class="mb-4">
                <div class="small text-uppercase fw-semibold opacity-75">
                    École primaire
                </div>

                <h4 class="fw-bold mb-1">
                    ALASSANE NDIAYE ALLOU
                </h4>
            </div>

            <hr class="border-light opacity-25">

            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-2">
                        <?= htmlspecialchars($eleve['prenom_eleve'] . " " . $eleve['nom_eleve']); ?>
                    </h5>

                    <div class="opacity-75">
                        <i class="fas fa-id-card me-2"></i>
                        Matricule :
                        <?= htmlspecialchars($eleve['matricule']); ?>
                    </div>
                </div>

            </div>

        </div>

        <!-- Situation scolaire actuelle -->
        <div class="card-body p-4">
            <h6 class="text-uppercase text-muted fw-bold mb-4">
                Situation scolaire actuelle
            </h6>
            <?php if($inscriptionActive !== false): ?>

            <div class="row g-4">

                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <div class="bg-light rounded-3 p-3 me-3 text-primary">
                            <i class="fas fa-school fa-lg"></i>
                        </div>

                        <div>
                            <small class="text-muted d-block">Classe</small>
                            <h5 class="fw-bold mb-0">
                                <?= htmlspecialchars($inscriptionActive['nom_classe']); ?>
                            </h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <div class="bg-light rounded-3 p-3 me-3 text-primary">
                            <i class="fas fa-calendar-alt fa-lg"></i>
                        </div>

                        <div>
                            <small class="text-muted d-block">Année scolaire</small>
                            <h5 class="fw-bold mb-0">
                                <?= htmlspecialchars($inscriptionActive['annee']); ?>
                            </h5>
                        </div>
                    </div>
                </div>

            </div>
                
            <?php else: ?>

            <div class="alert alert-info mb-0">
                <i class="fas fa-info-circle me-2"></i>
                Aucune inscription pour l'année scolaire en cours.
            </div>
            
            <?php endif; ?>
        </div>

    </div>

    <div class="row g-4">

        <!-- Informations personnelles -->
        <div class="col-lg-7">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-1">
                        <i class="fas fa-user-circle text-primary me-2"></i>
                        Informations personnelles
                    </h5>
                    <p class="text-muted small mb-0">
                        Identité et coordonnées de l'élève.
                    </p>
                </div>

                <div class="card-body px-4 pb-4">

                    <div class="row g-4">

                        <div class="col-sm-6">
                            <small class="text-muted d-block mb-1">Nom</small>
                            <span class="fw-semibold">
                                <?= htmlspecialchars($eleve['nom_eleve']); ?>
                            </span>
                        </div>

                        <div class="col-sm-6">
                            <small class="text-muted d-block mb-1">Prénom</small>
                            <span class="fw-semibold">
                                <?= htmlspecialchars($eleve['prenom_eleve']); ?>
                            </span>
                        </div>

                        <div class="col-sm-6">
                            <small class="text-muted d-block mb-1">Sexe</small>
                            <span class="fw-semibold">
                                <?= htmlspecialchars($eleve['sexe_eleve']); ?>
                            </span>
                        </div>

                        <div class="col-sm-6">
                            <small class="text-muted d-block mb-1">Date de naissance</small>
                            <span class="fw-semibold">
                                <?= htmlspecialchars($eleve['date_naissance']); ?>
                            </span>
                        </div>

                        <div class="col-sm-6">
                            <small class="text-muted d-block mb-1">Lieu de naissance</small>
                            <span class="fw-semibold">
                                <?= htmlspecialchars($eleve['lieu_naissance']); ?>
                            </span>
                        </div>

                        <div class="col-sm-6">
                            <small class="text-muted d-block mb-1">Adresse</small>
                            <span class="fw-semibold">
                                <?= htmlspecialchars($eleve['adresse_eleve']); ?>
                            </span>
                        </div>

                    </div>

                </div>
            </div>

        </div>


        <!-- Informations du tuteur -->
        <div class="col-lg-5">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-1">
                        <i class="fas fa-users text-primary me-2"></i>
                        Responsable légal
                    </h5>
                    <p class="text-muted small mb-0">
                        Informations de contact du tuteur.
                    </p>
                </div>

                <div class="card-body px-4 pb-4">

                    <div class="bg-light rounded-3 p-3 mb-3">
                        <small class="text-muted d-block mb-1">Nom du tuteur</small>
                        <h6 class="fw-bold mb-0">
                            <?= htmlspecialchars($eleve['nom_tuteur']); ?>
                        </h6>
                    </div>

                    <div class="bg-light rounded-3 p-3">
                        <small class="text-muted d-block mb-1">Téléphone</small>
                        <h6 class="fw-bold mb-0">
                            <i class="fas fa-phone-alt text-primary me-2"></i>
                            <?= htmlspecialchars($eleve['telephone_tuteur']); ?>
                        </h6>
                    </div>

                </div>
            </div>

        </div>

    </div>


    <!-- Historique scolaire -->
    <div class="card border-0 shadow-sm mt-4 mb-4">

        <div class="card-header bg-white border-0 px-4 pt-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center">

                <div>
                    <h5 class="fw-bold mb-1">
                        <i class="fas fa-history text-primary me-2"></i>
                        Parcours scolaire
                    </h5>
                    <p class="text-muted small mb-0">
                        Historique des inscriptions de l'élève au sein de l'établissement.
                    </p>
                </div>

                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 mt-2">
                    <i class="fas fa-graduation-cap me-1"></i>
                    Historique scolaire
                </span>

            </div>
        </div>

        <div class="card-body p-4">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th class="py-3">Année scolaire</th>
                            <th>Classe fréquentée</th>
                            <th class="text-center">Moyenne annuelle</th>
                            <th>Statut</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($recupEleve as $inscription): ?>
                            <tr>
                                <td><?= htmlspecialchars($inscription['annee']); ?></td>
                                <td><?= htmlspecialchars($inscription['nom_classe']); ?></td>
                                <td><?= htmlspecialchars($inscription['moyenne']) ?? ''; ?></td>
                                <td><?= htmlspecialchars($inscription['statut']); ?></td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>

                </table>
            </div>

            <div class="alert alert-info border-0 mt-3 mb-0">
                <i class="fas fa-info-circle me-2"></i>
                Les moyennes et les notes détaillées seront consultables ultérieurement
                depuis chaque année scolaire.
            </div>

        </div>
    </div>

</div>


<?php include_once('../includes/footer.php'); ?>