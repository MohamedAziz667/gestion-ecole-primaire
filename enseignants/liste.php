<?php
    include_once('../includes/auth_check.php');
    include_once('../includes/header.php');
    include_once('../includes/navbar.php');
    include_once('../includes/sidebar.php');
    include_once('../configuration/connexion.php');

    $message = $_SESSION['message'] ?? null;
    unset($_SESSION['message']);

    $type_message = $_SESSION['type_message'] ?? '';
    unset($_SESSION['type_message']);

    $nombreEnseignant = 1;

    $rqtEnseignant = "SELECT E.ID_enseignant, E.nom_enseignant, E.prenom_enseignant, E.matricule, E.email, E.date_naissance, E.lieu_naissance, E.grade, E.telephone, E.fonction, E.statut
                        FROM ENSEIGNANT E;";
    $stmtEnseignant = $connexion->prepare($rqtEnseignant);
    $stmtEnseignant->execute();
    $listeEnseignant = $stmtEnseignant->fetchAll(PDO::FETCH_ASSOC);
?>
    <div class="container-fluid px-4">

    <h1 class="mt-4">Gestion des enseignants</h1>

    <ol class="breadcrumb mb-4">

        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/index.php">
                Tableau de bord
            </a>
        </li>

        <li class="breadcrumb-item active">
            Enseignants
        </li>

    </ol>
    <div class="card mb-4">
        <?php if($type_message): ?>
            <div class="alert alert-<?= $type_message; ?>">
                <?= htmlspecialchars($message ?? ''); ?>
            </div>
        <?php endif; ?>

        <div class="card-header d-flex justify-content-between align-items-center">

            <div>

                <i class="fas fa-chalkboard-teacher me-2"></i>

                Liste des enseignants

            </div>


            <a
                href="/Gestion_Ecole_Primaire/enseignants/ajouter.php"
                class="btn btn-primary"
            >

                <i class="fas fa-plus me-1"></i>

                Ajouter un enseignant

            </a>


        </div>


        <div class="card-body">
            

            <div class="row mb-3">

                <div class="col-md-4">

                    <input
                        type="text"
                        class="form-control"
                        placeholder="Rechercher un enseignant..."
                    >

                </div>


            </div>


            <div class="w-100">
            <div class="table-responsive">


                <table class="table table-bordered table-hover align-middle">


                    <thead class="table-light">


                        <tr>

                            <th>#</th>
                            <th>Prénom</th>
                            <th>Nom</th>
                            <th>Matricule</th>
                            <th>Grade</th>
                            <th>Fontion</th>
                            <th>Date de naissance</th>
                            <th>Lieu de naissance</th>
                            <th>Téléphone</th>
                            <th>Email</th>
                            <th>Statut</th>
                            <th class="text-center">
                                Actions
                            </th>

                        </tr>


                    </thead>



                    <tbody>
                    <?php if(empty($listeEnseignant)): ?>
                        <tr>
                            <td colspan="12" class="text-center">Aucun enseignant enregistré</td>
                        </tr>
                    <?php else: ?>

                        <?php foreach($listeEnseignant as $enseignant): ?>
                        <tr>

                            <td>
                                <?= $nombreEnseignant++; ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($enseignant['prenom_enseignant']); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($enseignant['nom_enseignant']); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($enseignant['matricule']); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($enseignant['grade']); ?>
                            </td>

                            <td>
                                <?= $enseignant['fonction'] === 'adjoint' ? 'Adjoint' : ($enseignant['fonction'] === 'direction' ? 'Direction' : 'Non renseignée'); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($enseignant['date_naissance']); ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($enseignant['lieu_naissance']); ?>
                            </td>
                            
                            <td>
                                <?= htmlspecialchars($enseignant['telephone']); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($enseignant['email']); ?>
                            </td>
                            
                             <td>
                                <?= $enseignant['statut'] === 'actif' ? 'Actif' : ($enseignant['statut'] === ('inactif') ? 'Inactif' : 'Non renseigné'); ?>
                            </td>

                            <td class="text-center">


                                <a
                                    href="modifier.php?id=<?= $enseignant['ID_enseignant']; ?>"
                                    class="btn btn-warning btn-sm"
                                >

                                    <i class="fas fa-edit"></i>

                                    Modifier

                                </a>

                    <?php if($enseignant['statut'] === "actif"): ?>
                        <form
                            action="/Gestion_Ecole_Primaire/traitements/traiter_statut_enseignant.php"
                            method="POST"
                            class="d-inline"
                        >

                            <input type="hidden" name="action" value="desactiver">

                            <input type="hidden" name="id_enseignant" value="<?= $enseignant['ID_enseignant'] ?>">

                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-user-slash"></i>
                                Désactiver
                            </button>

                        </form>
                    <?php else: ?>
                        <!-- Formulaire d'activation -->
                        <form
                            action="/Gestion_Ecole_Primaire/traitements/traiter_statut_enseignant.php"
                            method="POST"
                            class="d-inline"
                        >

                            <input type="hidden" name="action" value="activer">

                            <input type="hidden" name="id_enseignant" value="<?= $enseignant['ID_enseignant'] ?>">

                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-user-check"></i>
                                Activer
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


    </div>


</div>
<?php 
    include_once('../includes/footer.php');
?>