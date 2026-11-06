<?php
    include_once('includes/auth_check.php');
    include_once('includes/header.php');
    include_once('includes/navbar.php');
    include_once('includes/sidebar.php');
    include_once('configuration/connexion.php');

    $rqtNbEleve = "SELECT COUNT(DISTINCT E.Id_eleve) AS nb_eleve
                    FROM ELEVE E
                    JOIN INSCRIPTION I ON E.Id_eleve = I.fk_id_eleve
                    JOIN ANNEE_SCOLAIRE A ON I.fk_id_anneeScolaire = A.Id_anneeScolaire
                    WHERE A.statut = 'active';";
    $stmtNbEleve = $connexion->prepare($rqtNbEleve);
    $stmtNbEleve->execute();
    $nbEleve = $stmtNbEleve->fetch(PDO::FETCH_ASSOC);

    $rqtNbClasse = "SELECT COUNT(DISTINCT C.Id_classe) AS nb_classe
                    FROM CLASSE C
                    JOIN ANNEE_SCOLAIRE A ON C.fk_id_anneeScolaire = A.Id_anneeScolaire
                    WHERE A.statut = 'active';";
    $stmtNbClasse = $connexion->prepare($rqtNbClasse);
    $stmtNbClasse->execute();
    $nbClasse = $stmtNbClasse->fetch(PDO::FETCH_ASSOC);

    $rqtNbEnseignant = "SELECT COUNT(DISTINCT E.ID_enseignant) AS nb_enseignant
                    FROM ENSEIGNANT E
                    JOIN AFFECTATION_ENSEIGNANT AE ON AE.fk_id_enseignant = E.ID_enseignant
                    JOIN ANNEE_SCOLAIRE A ON AE.fk_id_anneeScolaire = A.Id_anneeScolaire
                    WHERE A.statut = 'active' AND E.statut = 'actif';";
    $stmtNbEnseignant = $connexion->prepare($rqtNbEnseignant);
    $stmtNbEnseignant->execute();
    $nbEnseignant = $stmtNbEnseignant->fetch(PDO::FETCH_ASSOC);

    $rqtInscription = "SELECT COUNT(DISTINCT I.fk_id_eleve) AS nb_eleve_inscrit
                    FROM INSCRIPTION I
                    JOIN ELEVE E ON I.fk_id_eleve = E.Id_eleve
                    JOIN ANNEE_SCOLAIRE A ON I.fk_id_anneeScolaire = A.Id_anneeScolaire
                    WHERE A.statut = 'active';";
    $stmtInscription = $connexion->prepare($rqtInscription);
    $stmtInscription->execute();
    $nbInscription = $stmtInscription->fetch(PDO::FETCH_ASSOC);

    $rqtZoneGraphique = "SELECT C.nom_classe, COUNT(I.fk_id_eleve) AS nb_eleve_graphique
                    FROM CLASSE C
                    LEFT JOIN INSCRIPTION I ON C.Id_classe = I.fk_id_classe
                    LEFT JOIN ANNEE_SCOLAIRE A ON I.fk_id_anneeScolaire = A.Id_anneeScolaire
                    WHERE A.statut = 'active'
                    GROUP BY C.Id_classe, C.nom_classe
                    ORDER BY FIELD(C.nom_classe,
                        'CI', 'CIA', 'CIB',
                        'CP', 'CPA', 'CPB',
                        'CE1', 'CE1A', 'CE1B',
                        'CE2', 'CE2A', 'CE2B',
                        'CM1', 'CM1A', 'CM1B',
                        'CM2', 'CM2A', 'CM2B'
                    ) ASC;";
    $stmtZoneGraphique = $connexion->prepare($rqtZoneGraphique);
    $stmtZoneGraphique->execute();
    $zoneGraphique = $stmtZoneGraphique->fetchAll(PDO::FETCH_ASSOC);

    $nomClasse = [];
    $effectif = [];
    foreach($zoneGraphique as $zone){
        $nomClasse[] = $zone['nom_classe'];
        $effectif[] = (int)$zone['nb_eleve_graphique'];
    }

    $nomClasseJS = json_encode($nomClasse);
    $effectifJS = json_encode($effectif);
?>

    <div class="container-fluid px-4">

    <h1 class="mt-4">
        Tableau de bord
    </h1>


    <ol class="breadcrumb mb-4">

        <li class="breadcrumb-item active">
            Accueil
        </li>

    </ol>

    <!-- Cartes statistiques -->

    <div class="row">



        <div class="col-xl-3 col-md-6">


            <div class="card bg-primary text-white mb-4">


                <div class="card-body">


                    <div class="d-flex justify-content-between align-items-center">


                        <div>

                            <h5>
                                Élèves
                            </h5>

                            <h2>
                                <?php if($nbEleve === false): ?>
                                    <?= "0"; ?>
                                <?php else: ?>
                                    <?= $nbEleve['nb_eleve']; ?>
                                <?php endif; ?>
                            </h2>

                        </div>


                        <i class="fas fa-user-graduate fa-3x"></i>


                    </div>


                </div>


                <div class="card-footer d-flex align-items-center justify-content-between">
                    <i class="fas fa-angle-right"></i>
                </div>

            </div>


        </div>

        <div class="col-xl-3 col-md-6">


            <div class="card bg-success text-white mb-4">


                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h5>
                                Classes
                            </h5>

                            <h2>
                               <?php if($nbClasse === false): ?>
                                    <?= "0"; ?>
                                <?php else: ?>
                                    <?= $nbClasse['nb_classe']; ?>
                                <?php endif; ?>
                            </h2>

                        </div>


                        <i class="fas fa-school fa-3x"></i>


                    </div>


                </div>


                <div class="card-footer d-flex align-items-center justify-content-between">


                    <a
                        class="small text-white stretched-link"
                        href="/Gestion_Ecole_Primaire/classes/liste.php"
                    >

                        Voir les classes

                    </a>


                    <i class="fas fa-angle-right"></i>


                </div>


            </div>


        </div>

        <div class="col-xl-3 col-md-6">


            <div class="card bg-warning text-dark mb-4">


                <div class="card-body">


                    <div class="d-flex justify-content-between align-items-center">


                        <div>

                            <h5>
                                Enseignants
                            </h5>

                            <h2>
                                <?php if($nbEnseignant === false): ?>
                                    <?= "0"; ?>
                                <?php else: ?>
                                    <?= $nbEnseignant['nb_enseignant']; ?>
                                <?php endif; ?>
                            </h2>

                        </div>


                        <i class="fas fa-chalkboard-teacher fa-3x"></i>


                    </div>


                </div>


                <div class="card-footer d-flex align-items-center justify-content-between">


                    <a
                        class="small text-dark stretched-link"
                        href="/Gestion_Ecole_Primaire/enseignants/liste.php"
                    >

                        Voir les enseignants

                    </a>


                    <i class="fas fa-angle-right"></i>


                </div>


            </div>


        </div>

        <div class="col-xl-3 col-md-6">


            <div class="card bg-danger text-white mb-4">


                <div class="card-body">


                    <div class="d-flex justify-content-between align-items-center">


                        <div>

                            <h5>
                                Inscriptions
                            </h5>

                            <h2>
                                <?php if($nbInscription === false): ?>
                                    <?= "0"; ?>
                                <?php else: ?>
                                    <?= $nbInscription['nb_eleve_inscrit']; ?>
                                <?php endif; ?>
                            </h2>

                        </div>


                        <i class="fas fa-file-signature fa-3x"></i>


                    </div>


                </div>

                <div class="card-footer d-flex align-items-center justify-content-between">


                    <a
                        class="small text-white stretched-link"
                        href="/Gestion_Ecole_Primaire/inscriptions/liste.php"
                    >

                        Voir les inscriptions

                    </a>


                    <i class="fas fa-angle-right"></i>


                </div>


            </div>


        </div>


    </div>


    <!-- Graphique + dernières informations -->

    <div class="row">


        <div class="col-xl-8">


            <div class="card mb-4">


                <div class="card-header">

                    <i class="fas fa-chart-bar me-1"></i>

                    Effectifs par classe

                </div>


                <div class="card-body">


                    <div
                        style="height:300px;"
                        class="d-flex justify-content-center align-items-center"
                    >

                        <span class="text-muted">

                            <div style="height: 300px;">
                                <canvas id="graphiqueEffectifs"></canvas>
                            </div>

                        </span>


                    </div>


                </div>


            </div>


        </div>


        <div class="col-xl-4">


            <div class="card mb-4">


                <div class="card-header">

                    <i class="fas fa-calendar me-1"></i>

                    Année scolaire active

                </div>


                <div class="card-body text-center">


                    <h3>

                        2026 - 2027

                    </h3>


                    <p class="text-muted">

                        Année scolaire en cours

                    </p>


                </div>


            </div>


        </div>



    </div>


    <!-- Accès rapides -->


    <div class="card mb-4">


        <div class="card-header">


            <i class="fas fa-bolt me-1"></i>

            Accès rapides


        </div>


        <div class="card-body">


            <div class="row text-center">



                <div class="col-md-3 mb-3">


                    <a
                        href="/Gestion_Ecole_Primaire/inscriptions/ajouter.php"
                        class="btn btn-primary w-100"
                    >

                        <i class="fas fa-user-plus me-1"></i>

                        Nouvelle inscription

                    </a>


                </div>

                <div class="col-md-3 mb-3">


                    <a
                        href="/Gestion_Ecole_Primaire/classes/ajouter.php"
                        class="btn btn-success w-100"
                    >

                        <i class="fas fa-school me-1"></i>

                        Nouvelle classe

                    </a>


                </div>


                <div class="col-md-3 mb-3">


                    <a
                        href="/Gestion_Ecole_Primaire/evaluations/ajouter.php"
                        class="btn btn-warning w-100"
                    >

                        <i class="fas fa-edit me-1"></i>

                        Saisir notes

                    </a>


                </div>


                <div class="col-md-3 mb-3">


                    <a
                        href="/Gestion_Ecole_Primaire/enseignants/ajouter.php"
                        class="btn btn-danger w-100"
                    >

                        <i class="fas fa-user-tie me-1"></i>

                        Ajouter enseignant

                    </a>


                </div>


            </div>


        </div>


    </div>



</div>

<?php
    include_once('includes/footer.php');
?>
<script src="public/js/chart.umd.min.js"></script>
<script>
    
    const nomClasse = <?= $nomClasseJS ?>;
    const effectif = <?= $effectifJS ?>;

    const zoneGraphique = document.getElementById('graphiqueEffectifs');

    new Chart(zoneGraphique, {
        type: 'bar',
        data: {
            labels: nomClasse,
            datasets: [{
                label: "Nombre d'élèves",
                data: effectif
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>