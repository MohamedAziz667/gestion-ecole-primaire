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

    $rqtClasseEnseignant = "SELECT C.Id_classe, C.nom_classe, E.nom_enseignant, E.prenom_enseignant
                            FROM classe C
                            LEFT JOIN enseignant E ON C.fk_id_enseignant = E.ID_enseignant
                            ORDER BY C.nom_classe ASC;";
    $stmtClasseEnseignant = $connexion->prepare($rqtClasseEnseignant);
    $stmtClasseEnseignant->execute();
    $listeClasseEnseignant = $stmtClasseEnseignant->fetchAll(PDO::FETCH_ASSOC);

    $rqtNbEleveInscrit = "SELECT COUNT(I.fk_id_eleve) AS nb_eleve, C.Id_classe
                            FROM CLASSE C
                            LEFT JOIN INSCRIPTION I ON C.Id_classe = I.fk_id_classe AND I.fk_id_anneeScolaire = (SELECT Id_anneeScolaire
                                                                                                                FROM ANNEE_SCOLAIRE
                                                                                                                ORDER BY annee DESC
                                                                                                                LIMIT 1)
                            GROUP BY C.Id_classe;";
    $stmtNbEleveInscrit = $connexion->prepare($rqtNbEleveInscrit);
    $stmtNbEleveInscrit->execute();
    $listeNbEleveInscrit = $stmtNbEleveInscrit->fetchAll(PDO::FETCH_ASSOC);
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

    <div class="card mb-4">
 
        <div class="card-header d-flex justify-content-between align-items-center">

            <div>
                <i class="fas fa-school me-2"></i>
                Liste des classes
            </div>

            <a href="/Gestion_Ecole_Primaire/classes/ajouter.php"
               class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Ajouter une classe
            </a>

        </div>

        <div class="card-body">

            <div class="row mb-3">

                <div class="col-md-4">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Rechercher une classe..."
                    >
                </div>

            </div>

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

                                <a
                                    href="#"
                                    class="btn btn-warning btn-sm"
                                >
                                    <i class="fas fa-edit"></i>
                                    Modifier
                                </a>

                                <a
                                    href="#"
                                    class="btn btn-danger btn-sm"
                                >
                                    <i class="fas fa-trash"></i>
                                    Supprimer
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

</div>
<?php include_once('../includes/footer.php'); ?>