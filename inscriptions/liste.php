<?php
    include_once('../includes/auth_check.php');
    include_once('../includes/header.php');
    include_once('../includes/navbar.php');
    include_once('../includes/sidebar.php');
    include_once('../configuration/connexion.php');

    $rqtClasse = "SELECT Id_classe, nom_classe
              FROM CLASSE
              ORDER BY nom_classe;";

    $stmtClasse = $connexion->prepare($rqtClasse);
    $stmtClasse->execute();
    $listeClasse = $stmtClasse->fetchAll(PDO::FETCH_ASSOC);

    $rqtAnnee = "SELECT Id_anneeScolaire, annee
              FROM ANNEE_SCOLAIRE
              ORDER BY annee;";

    $stmtAnnee = $connexion->prepare($rqtAnnee);
    $stmtAnnee->execute();
    $listeAnnee = $stmtAnnee->fetchAll(PDO::FETCH_ASSOC);

    $recherche = $_GET['recherche'] ?? "";
    $classe = $_GET['classe'] ?? "";
    $annee = $_GET['annee'] ?? "";
    $conditions = [];
    $parametre = [];
    if ($recherche !== "") {
        $conditions[] = "(E.nom_eleve LIKE ? OR E.prenom_eleve LIKE ? OR E.matricule LIKE ?)";
        $parametre[] = "%" . $recherche . "%";
        $parametre[] = "%" . $recherche . "%";
        $parametre[] = "%" . $recherche . "%";
    }
    if($classe !== ""){
        $conditions[] = "C.nom_classe = ?";
        $parametre[] = $classe;
    }
    if($annee !== ""){
        $conditions[] = "A.annee = ?";
        $parametre[] = $annee;
    }
    $rqtFiltre = "SELECT E.nom_eleve, E.prenom_eleve, E.matricule, C.nom_classe, A.annee, I.statut
                    FROM INSCRIPTION I
                    JOIN ELEVE E ON I.fk_id_eleve = E.Id_eleve
                    JOIN CLASSE C ON I.fk_id_classe = C.Id_classe
                    JOIN ANNEE_SCOLAIRE A ON I.fk_id_anneeScolaire = A.Id_anneeScolaire";
    if(!empty($conditions)){
        $rqtFiltre .= " WHERE " . implode(" AND ", $conditions);
    }
    $rqtFiltre .= ";";
    $stmtFiltre = $connexion->prepare($rqtFiltre);
    $stmtFiltre->execute($parametre);
    $listeInscription = $stmtFiltre->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid px-4">

    <h1 class="mt-4">Gestion des inscriptions</h1>

    <ol class="breadcrumb mb-4">

        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/index.php">
                Tableau de bord
            </a>
        </li>

        <li class="breadcrumb-item active">
            Inscriptions
        </li>

    </ol>



    <div class="card mb-4">


        <div class="card-header d-flex justify-content-between align-items-center">


            <div>

                <i class="fas fa-user-plus me-2"></i>

                Liste des inscriptions

            </div>



            <a
                href="/Gestion_Ecole_Primaire/inscriptions/ajouter.php"
                class="btn btn-primary"
            >

                <i class="fas fa-plus me-1"></i>

                Nouvelle inscription

            </a>


        </div>





        <div class="card-body">



            <!-- Filtres -->
            <form method="GET">
                <div class="row mb-4">

                    <div class="col-md-4">
                        <input
                            type="text"
                            name="recherche"
                            class="form-control"
                            placeholder="Rechercher un élève..."
                            value="<?= $recherche; ?>"
                        >
                    </div>

                    <div class="col-md-3">
                        <select name="classe" class="form-select">

                            <option value="">Toutes les classes</option>

                            <?php foreach($listeClasse as $classeItem): ?>
                                <option
                                    value="<?= $classeItem['nom_classe']; ?>"
                                    <?= $classe === $classeItem['nom_classe'] ? 'selected' : ''; ?>
                                >
                                    <?= $classeItem['nom_classe']; ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="annee" class="form-select">
                            <option value="">Toutes les années</option>
                        <?php foreach($listeAnnee as $anneeItems): ?>
                            <option value="<?= $anneeItems['annee']; ?>"
                                <?= $annee === $anneeItems['annee'] ? 'selected' : ''; ?>
                            >
                                <?= $anneeItems['annee']; ?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            <i class="fas fa-search me-1"></i>
                            Rechercher
                        </button>
                    </div>

                </div>
            </form>

            <!-- Tableau -->

            <div class="table-responsive">


                <table class="table table-bordered table-hover align-middle">


                    <thead class="table-light">


                        <tr>

                            <th>#</th>
                            <th>Nom élève</th>
                            <th>Prénom</th>
                            <th>Classe</th>
                            <th>Année scolaire</th>
                            <th>Statut</th>
                            <th class="text-center">
                                Actions
                            </th>

                        </tr>


                    </thead>


                    <tbody>
                        <?php foreach($listeInscription as $inscription): ?>
                            <tr>
                                <td><?= $inscription["matricule"] ?></td>
                                <td><?= $inscription["nom_eleve"]; ?></td>
                                <td><?= $inscription["prenom_eleve"]; ?></td>
                                <td><?= $inscription["nom_classe"]; ?></td>
                                <td><?= $inscription["annee"]; ?></td>
                                <td><?= $inscription["statut"]; ?></td>

                            <td class="text-center">


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

                    </tbody>



                </table>


            </div>


        </div>


    </div>



</div>
<?php include_once('../includes/footer.php'); ?>
