<?php
    include_once('../includes/auth_check.php');
    include_once('../includes/header.php');
    include_once('../includes/navbar.php');
    include_once('../includes/sidebar.php');
    include_once('../configuration/connexion.php');

    $message = $_SESSION['message'] ?? '';
    unset($_SESSION['message']);

    $type_message = $_SESSION['type_message'] ?? '';
    unset($_SESSION['type_message']);


    $rqtAnnee = "SELECT Id_anneeScolaire, annee, statut
                FROM ANNEE_SCOLAIRE
                WHERE statut <> 'preparation'
                ORDER BY annee DESC;";
    $stmtAnnee = $connexion->prepare($rqtAnnee);
    $stmtAnnee->execute();
    $listeAnnee = $stmtAnnee->fetchAll(PDO::FETCH_ASSOC);

    $rqtAnneeActive = "SELECT Id_anneeScolaire, annee
                FROM ANNEE_SCOLAIRE
                WHERE statut = 'active';";
    $stmtAnneeActive = $connexion->prepare($rqtAnneeActive);
    $stmtAnneeActive->execute();
    $anneeActive = $stmtAnneeActive->fetch(PDO::FETCH_ASSOC);

    $anneeSelectionnee = $_GET['annee'] ?? '';
    $anneeActiveDisponible = true;
    $anneeVerif = false;
    if ($anneeActive !== false) {
        if ($anneeSelectionnee === '') {
            $anneeSelectionnee = $anneeActive['Id_anneeScolaire'];
        }
        if (filter_var($anneeSelectionnee, FILTER_VALIDATE_INT) && $anneeSelectionnee > 0) {
            $rqtVerifAnnee = "SELECT Id_anneeScolaire
                            FROM ANNEE_SCOLAIRE
                            WHERE (statut = 'cloturee' OR statut = 'active') AND Id_anneeScolaire = ?;";
            $stmtVerifAnnee = $connexion->prepare($rqtVerifAnnee);
            $stmtVerifAnnee->execute([$anneeSelectionnee]);
            $anneeVerif = $stmtVerifAnnee->fetch(PDO::FETCH_ASSOC);
        }
        if ($anneeVerif === false) {
            $anneeSelectionnee = $anneeActive['Id_anneeScolaire'];
        }else{
            $anneeSelectionnee = $anneeVerif['Id_anneeScolaire'];
        }
    }else{
        $anneeActiveDisponible = false;
    }

    $rqtClasseEnseignant = "SELECT C.Id_classe, C.nom_classe, E.nom_enseignant, E.prenom_enseignant
                            FROM classe C
                            LEFT JOIN enseignant E ON C.fk_id_enseignant = E.ID_enseignant
                            INNER JOIN ANNEE_SCOLAIRE A ON C.fk_id_anneeScolaire = A.Id_anneeScolaire
                            WHERE A.Id_anneeScolaire = ?
                            ORDER BY C.nom_classe ASC;";
    $stmtClasseEnseignant = $connexion->prepare($rqtClasseEnseignant);
    $stmtClasseEnseignant->execute([$anneeSelectionnee]);
    $listeClasseEnseignant = $stmtClasseEnseignant->fetchAll(PDO::FETCH_ASSOC);

    $rqtNbEleveInscrit = "SELECT COUNT(I.fk_id_eleve) AS nb_eleve, C.Id_classe
                            FROM CLASSE C
                            LEFT JOIN INSCRIPTION I ON C.Id_classe = I.fk_id_classe AND I.fk_id_anneeScolaire = ?
                            WHERE C.fk_id_anneeScolaire = ?
                            GROUP BY C.Id_classe;";
    $stmtNbEleveInscrit = $connexion->prepare($rqtNbEleveInscrit);
    $stmtNbEleveInscrit->execute([$anneeSelectionnee, $anneeSelectionnee]);
    $listeNbEleveInscrit = $stmtNbEleveInscrit->fetchAll(PDO::FETCH_ASSOC);

    $anneeSelectionneeInfo = null;
    foreach ($listeAnnee as $annee) {
        if ($annee['Id_anneeScolaire'] == $anneeSelectionnee) {
            $anneeSelectionneeInfo = $annee;
            break;
        }
    }
?>

<div class="container-fluid px-4">

    <h1 class="mt-4">Gestion des classes</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/index.php">Tableau de bord</a>
        </li>
        <li class="breadcrumb-item active">Classes</li>
    </ol>

    <?php if($message): ?>
        <div class="alert alert-<?= $type_message; ?>">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?= htmlspecialchars($message); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    <?php endif; ?>

    <?php if($anneeActiveDisponible === true): ?>
    <div class="card mb-4">
 
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

            <div>
                <i class="fas fa-school me-2"></i>
                Liste des classes
            </div>
            
           <form method="GET" class="d-flex flex-column flex-sm-row align-items-sm-center gap-2 mb-0">
                        <label for="annee" class="form-label">
                            Année scolaire
                        </label>

                        <select
                            name="annee" id="annee" class="form-select" onchange="this.form.submit()">
                            <?php foreach($listeAnnee as $annee): ?>
                                <option value="<?= $annee['Id_anneeScolaire'] ?>"
                                <?= $annee['Id_anneeScolaire'] == $anneeSelectionnee ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($annee['annee']); ?>
                                </option>
                            <?php endforeach; ?>

                        </select>

                        <?php if ($anneeSelectionneeInfo !== null): ?>
                            <?php if ($anneeSelectionneeInfo['statut'] === 'active'): ?>
                                <span class="badge bg-success">Année active</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Année clôturée</span>
                            <?php endif; ?>
                        <?php endif; ?>
            </form>

            <?php if ($anneeSelectionneeInfo !== null && $anneeSelectionneeInfo['statut'] === 'active'): ?>
                <a href="/Gestion_Ecole_Primaire/classes/ajouter.php"
                class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Ajouter une classe
                </a>
            <?php endif; ?>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>Nom de la classe</th>
                            <th>Enseignant</th>
                            <th class="text-center">Nombre d'élèves</th>
                            <th class="text-center">Actions</th>

                        </tr>

                    </thead>

                    <tbody>
                        <?php if(empty($listeClasseEnseignant)): ?>
                            <tr>
                                <td colspan="4" class="text-center">Aucune classe enregistrée.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($listeClasseEnseignant as $classeEnseignant): ?>
                        <tr>

                            <td>
                                <?= htmlspecialchars($classeEnseignant['nom_classe']); ?>
                            </td>
                            <td>
                               <?= htmlspecialchars(($classeEnseignant['prenom_enseignant'] ?? '') . " " . ($classeEnseignant['nom_enseignant'] ?? '')); ?>
                            </td>
                            <?php 
                                $effectif = 0; 
                                foreach($listeNbEleveInscrit as $nbEleveInscrit){
                                    if ($classeEnseignant['Id_classe'] == $nbEleveInscrit['Id_classe']) {
                                        $effectif = $nbEleveInscrit['nb_eleve'];
                                    }
                                }
                            ?>
                            <td class="text-center">
                                <?= $effectif; ?>
                            </td>

                            <td class="text-center">

                                <a
                                    href="/Gestion_Ecole_Primaire/classes/detail.php?id=<?= $classeEnseignant['Id_classe']; ?>"
                                    class="btn btn-info btn-sm"
                                >
                                    <i class="fas fa-eye"></i>
                                    Voir
                                </a>

                                <?php if ($anneeSelectionneeInfo !== null && $anneeSelectionneeInfo['statut'] === 'active'): ?>
                                    <a
                                        href="modifier.php?id=<?= $classeEnseignant['Id_classe']; ?>"
                                        class="btn btn-warning btn-sm"
                                    >
                                        <i class="fas fa-edit"></i>
                                        Modifier
                                    </a>

                                    <form method="POST" action="supprimer.php" class="d-inline">
                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?= $classeEnseignant['Id_classe']; ?>"
                                        >
                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Voulez-vous vraiment supprimer cette classe ?');"
                                        >
                                            <i class="fas fa-trash"></i>
                                            Supprimer
                                        </button>
                                    </form>
                                <?php endif; ?>

                            </td>

                        </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>
    <?php endif; ?>

</div>
<?php include_once('../includes/footer.php'); ?>