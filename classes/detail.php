<?php
    include_once('../includes/auth_check.php');
    include_once('../configuration/connexion.php');

    $message = $_SESSION['message'] ?? null;
    $type_message = $_SESSION['type_message'] ?? null;

    unset($_SESSION['message'], $_SESSION['type_message']);

    $id = $_GET['id'] ?? '';
    if (!filter_var($id, FILTER_VALIDATE_INT) || $id <= 0) {
        $_SESSION['message'] = "Identifiant de classe invalide.";
        $_SESSION['type_message'] = "danger";
        header("Location: ../classes/liste.php");
        exit();
    }

    $rqtVerifClasse = "SELECT C.Id_classe
                        FROM CLASSE C
                        WHERE C.Id_classe = ?;";
    $stmtVerifClasse = $connexion->prepare($rqtVerifClasse);
    $stmtVerifClasse->execute([$id]);
    $classeTrouvee = $stmtVerifClasse->fetch();
    if($classeTrouvee === false){
        $_SESSION['message'] = "La classe demandée n'existe pas.";
        $_SESSION['type_message'] = "danger";
        header("Location: ../classes/liste.php");
        exit();
    }
    include_once('../includes/header.php');
    include_once('../includes/navbar.php');
    include_once('../includes/sidebar.php');

    $rqtClasse = "SELECT C.nom_classe, E.nom_enseignant, E.prenom_enseignant
                    FROM CLASSE C
                    LEFT JOIN ENSEIGNANT E ON C.fk_id_enseignant = E.ID_enseignant
                    WHERE C.Id_classe = ?;";
    $stmtClasse = $connexion->prepare($rqtClasse);
    $stmtClasse->execute([$id]);
    $classe = $stmtClasse->fetch();

    $rqtAnnee = "SELECT Id_anneeScolaire, annee
                FROM ANNEE_SCOLAIRE
                ORDER BY annee DESC
                LIMIT 1;";
    $stmtAnnee = $connexion->prepare($rqtAnnee);
    $stmtAnnee->execute();
    $annee = $stmtAnnee->fetch();

    $rqtEffectif = "SELECT
                COUNT(*) AS effectif_total, SUM(CASE WHEN E.sexe_eleve = 'M' THEN 1 ELSE 0 END) AS nb_garcons,
                SUM(CASE WHEN E.sexe_eleve = 'F' THEN 1 ELSE 0 END) AS nb_filles
            FROM INSCRIPTION I
            INNER JOIN ELEVE E ON I.fk_id_eleve = E.ID_eleve
            WHERE I.fk_id_classe = ?
            AND I.fk_id_anneeScolaire = ?;";

    $stmtEffectif = $connexion->prepare($rqtEffectif);
    $stmtEffectif->execute([$id, $annee['Id_anneeScolaire']]);
    $effectif = $stmtEffectif->fetch(PDO::FETCH_ASSOC);

    $rqtEleve = "SELECT E.ID_eleve, E.nom_eleve, E.prenom_eleve, E.matricule, E.sexe_eleve, E.date_naissance, E.lieu_naissance, E.adresse_eleve, E.nom_tuteur, E.telephone_tuteur
                FROM INSCRIPTION I
                JOIN ELEVE E ON E.Id_eleve = I.fk_id_eleve
                JOIN CLASSE C ON C.Id_classe = I.fk_id_classe
                JOIN ANNEE_SCOLAIRE A ON A.Id_anneeScolaire = I.fk_id_anneeScolaire
                WHERE I.fk_id_classe = ?
                AND I.fk_id_anneeScolaire = ?
                ORDER BY E.nom_eleve ASC, E.prenom_eleve ASC;";
    $stmtEleve = $connexion->prepare($rqtEleve);
    $stmtEleve->execute([$id, $annee['Id_anneeScolaire']]);
    $listeEleve = $stmtEleve->fetchAll(PDO::FETCH_ASSOC);
    $nbEleve = 1;

    ?>

<div class="container-fluid px-4">

    <h1 class="mt-4">Détails de la classe</h1>

    <ol class="breadcrumb mb-4 no-print">
        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/index.php">Tableau de bord</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/classes/liste.php">Classes</a>
        </li>
        <li class="breadcrumb-item active">Détails</li>
    </ol>

    <?php if($message): ?>
        <div class="alert alert-<?= $type_message; ?>">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?= htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <!-- Informations principales -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">

                <div class="col-md-5 mb-3 mb-md-0">
                    <div class="text-muted small mb-1">CLASSE</div>
                    <h2 class="text-primary fw-bold mb-0"><?= htmlspecialchars($classe['nom_classe']); ?></h2>
                </div>

                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="text-muted small mb-1">ENSEIGNANT TITULAIRE</div>
                    <h5 class="mb-0"><?= htmlspecialchars($classe['prenom_enseignant'] . " " . $classe['nom_enseignant']); ?></h5>
                </div>

                <div class="col-md-3">
                    <div class="text-muted small mb-1">ANNÉE SCOLAIRE</div>
                    <h5 class="mb-0"><?= $annee['annee']; ?></h5>
                </div>

            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row mb-4">

        <div class="col-xl-4 col-md-6 mb-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small mb-2">EFFECTIF TOTAL</div>
                            <h2 class="fw-bold mb-0"><?= $effectif['effectif_total']; ?></h2>
                            <div class="small mt-1">Élèves inscrits</div>
                        </div>
                        <div class="fs-1">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small mb-2">GARÇONS</div>
                            <h2 class="fw-bold mb-0"><?= $effectif['nb_garcons']; ?></h2>
                            <div class="small mt-1">Élèves de sexe masculin</div>
                        </div>
                        <div class="fs-1">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-3">
            <div class="card bg-warning text-dark h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small mb-2">FILLES</div>
                            <h2 class="fw-bold mb-0"><?= $effectif['nb_filles']; ?></h2>
                            <div class="small mt-1">Élèves de sexe féminin</div>
                        </div>
                        <div class="fs-1">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Choix de l'année et exportation -->
    <div class="card shadow-sm mb-4 no-print">
        <div class="card-body">
            <div class="row align-items-end">

                <div class="col-lg-4 col-md-6 mb-3 mb-lg-0">
                    <label for="anneeScolaire" class="form-label fw-semibold">
                        Année scolaire
                    </label>

                    <select class="form-select" id="anneeScolaire">
                        <option value="1">2025-2026</option>
                        <option value="2" selected>2026-2027</option>
                    </select>
                </div>

                <div class="col-lg-8 text-lg-end">
                    <button
                        type="button"
                        class="btn btn-outline-secondary me-1 mb-1"
                        onclick="window.print()"
                    >
                        <i class="fas fa-print me-1"></i>
                        Imprimer / PDF
                    </button>

                    <button
                        type="button"
                        class="btn btn-outline-success mb-1"
                        disabled
                        title="Export Excel à développer"
                    >
                        <i class="fas fa-file-excel me-1"></i>
                        Exporter Excel
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Tableau détaillé des élèves -->
    <div class="card shadow-sm mb-4">

        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-users me-2"></i>
                <strong>Liste détaillée des élèves</strong>
            </div>

            <span class="badge bg-primary"><?= $effectif['effectif_total']; ?> élèves</span>
        </div>

        <div class="card-body">
<!-- 
            <div class="alert alert-info no-print">
                <i class="fas fa-info-circle me-2"></i>
                Les élèves seront classés par nom, puis par prénom.
                Les données présentées sont fictives.
            </div> -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">N°</th>
                            <th>Matricule</th>
                            <th>Prénom</th>
                            <th>Nom</th>
                            <th>Sexe</th>
                            <th>Date de naissance</th>
                            <th>Lieu de naissance</th>
                            <th>Adresse</th>
                            <th>Parent / Tuteur</th>
                            <th>Téléphone du tuteur</th>
                            <th class="text-center no-print">Actions</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php if(empty($listeEleve)): ?>
                            <tr>
                                <td colspan="11" text-center>
                                    Aucun élève inscrit dans cette classe pour cette année scolaire.
                                </td>
                            </tr>
                        <?php else: ?>
                        <?php foreach($listeEleve as $eleve): ?>
                        <tr>
                            <td class="text-center"><?= $nbEleve++; ?></td>
                            <td><?= htmlspecialchars($eleve['matricule']); ?></td>
                            <td><?= htmlspecialchars($eleve['prenom_eleve']); ?></td>
                            <td><?= htmlspecialchars($eleve['nom_eleve']); ?></td>
                            <td><?= htmlspecialchars($eleve['sexe_eleve']); ?></td>
                            <td><?= (new DateTime($eleve['date_naissance']))->format('d-m-Y'); ?></td>
                            <td><?= htmlspecialchars($eleve['lieu_naissance']); ?></td>
                            <td><?= htmlspecialchars($eleve['adresse_eleve']); ?></td>
                            <td><?= htmlspecialchars($eleve['nom_tuteur'] ?? ''); ?></td>
                            <td><?= htmlspecialchars($eleve['telephone_tuteur'] ?? ''); ?></td>
                            <td class="text-center no-print">
                                <a href="/Gestion_Ecole_Primaire/eleves/modifier.php?id=<?= $eleve['ID_eleve']; ?>&idClasse=<?= $id; ?>"
                                class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                    Modifier
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>

    <div class="d-flex justify-content-end mb-4 no-print">
        <a
            href="/Gestion_Ecole_Primaire/classes/liste.php"
            class="btn btn-secondary"
        >
            <i class="fas fa-arrow-left me-1"></i>
            Retour aux classes
        </a>
    </div>

</div>

<?php include_once('../includes/footer.php'); ?>