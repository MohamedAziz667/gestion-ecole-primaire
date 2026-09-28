<?php
    include_once('../includes/auth_check.php');
    include_once('../includes/header.php');
    include_once('../includes/navbar.php');
    include_once('../includes/sidebar.php');
    include_once('../configuration/connexion.php');

    function charger_eleves($connexion, $classe, $annee){
        $rqtEleve = "SELECT E.Id_eleve, E.nom_eleve, E.prenom_eleve, C.nom_classe
                             FROM eleve E
                             JOIN inscription I ON E.Id_eleve = I.fk_id_eleve
                             JOIN classe C ON I.fk_id_classe = C.Id_classe
                             WHERE I.fk_id_classe = ?
                             AND I.fk_id_anneeScolaire = ?
                             ORDER BY nom_eleve ASC, prenom_eleve ASC;";
        $stmtEleve = $connexion->prepare($rqtEleve);
        $stmtEleve->execute([$classe, $annee]);
        $liste_eleve = $stmtEleve->fetchAll(PDO::FETCH_ASSOC);
        return $liste_eleve;
    }

    $rqtAnnee = "SELECT A.Id_anneeScolaire, A.annee
                 FROM annee_scolaire A
                 ORDER BY CAST(SUBSTRING(A.annee, 1, 4) AS UNSIGNED) DESC;";

    $stmtAnnee = $connexion->prepare($rqtAnnee);
    $stmtAnnee->execute();
    $liste_annee = $stmtAnnee->fetchAll(PDO::FETCH_ASSOC);
    
    $rqtClasse = "SELECT C.Id_classe, C.nom_classe
                  FROM classe C;";
    $stmtClasse = $connexion->prepare($rqtClasse);
    $stmtClasse->execute();
    $liste_classe = $stmtClasse->fetchAll(PDO::FETCH_ASSOC);

    $rqtMatiere = "SELECT M.ID_matiere, M.nom_matiere
                  FROM matiere M;";
    $stmtMatiere = $connexion->prepare($rqtMatiere);
    $stmtMatiere->execute();
    $liste_matiere = $stmtMatiere->fetchAll(PDO::FETCH_ASSOC);

    $liste_eleve = [];
    $idAnneeSelectionnee = "";
    $idClasseSelectionnee = "";
    $idMatiereSelectionnee = "";
    $idCompositionSelectionnee = "";
    $notesSaisies = [];
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if ($_POST["action"] === "charger") {
            if (!empty($_POST["fk_id_anneeScolaire"]) && !empty($_POST["fk_id_classe"])) {
                $idAnnee = $_POST["fk_id_anneeScolaire"];
                $idAnneeSelectionnee = $idAnnee;
                $idClasse = $_POST["fk_id_classe"];
                $idClasseSelectionnee = $idClasse;
                $idMatiere = $_POST["fk_id_matiere"];
                $idMatiereSelectionnee = $idMatiere;
                if (isset($_POST["fk_id_composition"])) {
                    $idComposition = $_POST["fk_id_composition"];
                    $idCompositionSelectionnee = $idComposition;
                }
                $liste_eleve = charger_eleves($connexion, $idClasse, $idAnnee);
            }

        }

        if ($_POST["action"] === "enregistrer") {
                if (!empty($_POST["fk_id_anneeScolaire"]) && !empty($_POST["fk_id_classe"]) && !empty($_POST["fk_id_matiere"]) && !empty($_POST["fk_id_composition"])) {
                    $erreur = "";
                    $annee = $_POST["fk_id_anneeScolaire"];
                    $classe = $_POST["fk_id_classe"];
                    $matiere = $_POST["fk_id_matiere"];
                    $composition = $_POST["fk_id_composition"];
                    $notesSaisies = $_POST["note"];

                    $idAnneeSelectionnee = $annee;
                    $idClasseSelectionnee = $classe;
                    $idMatiereSelectionnee = $matiere;
                    $idCompositionSelectionnee = $composition;

                    $liste_eleve = charger_eleves($connexion, $classe, $annee);

                
                    foreach ($_POST["note"] as $idEleve => $note) {
                        if ($note === "") {
                            continue;
                        }
                        if ($note < 0 || $note > 20) {
                            foreach ($liste_eleve as $eleve){
                                if ($eleve["Id_eleve"] == $idEleve) {
                                    $nom = $eleve["nom_eleve"];
                                    $prenom = $eleve["prenom_eleve"];
                                }
                            }
                                $erreur .= "La note " . $note . " saisie pour " . $prenom . " " . $nom . " est invalide. Elle doit être comprise entre 0 et 20." . "<br>";
                        }
                    }
                    if ($erreur !== "") {
                        echo $erreur;
                    }else{
                        try {
                            $rqtEvaluation = "INSERT INTO evaluation(note, fk_id_eleve, fk_id_classe, fk_id_anneeScolaire, fk_id_matiere, fk_id_composition)
                            VALUES(?, ?, ?, ?, ?, ?);";
                            $stmtEvaluation = $connexion->prepare($rqtEvaluation);
                            $connexion->beginTransaction();
                            foreach ($_POST["note"] as $idEleve => $note){
                                if ($note === "") {
                                continue;
                            }
                                $stmtEvaluation->execute([$note, $idEleve, $classe, $annee, $matiere, $composition]);
                            }
                            $connexion->commit();
                            $notesSaisies = [];
                            echo "Les évaluations ont été enregistrées avec succès.";
                        } catch (PDOException $messageErreur) {
                            $connexion->rollBack();
                            $code = $messageErreur->errorInfo[1];
                            if ($code == 1062) {
                                echo "Cette évaluation existe déjà.";
                            }else{
                                echo "Une erreur est survenue lors de l'enregistrement.";
                            }
                        }
                    }
                }
            }
        
    }
    $nombre_eleve = 0;
//     echo "<pre>";
// print_r($_POST);
// echo "</pre>";

?>
<div class="container-fluid px-4">

    <h1 class="mt-4">Saisie des évaluations</h1>

    <ol class="breadcrumb mb-4">

        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/index.php">
                Tableau de bord
            </a>
        </li>

        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/evaluations/liste.php">
                Évaluations
            </a>
        </li>

        <li class="breadcrumb-item active">
            Nouvelle évaluation
        </li>

    </ol>

    <!-- Paramètres de l'évaluation -->

    <form method="POST">

        <div class="card mb-4">

            <div class="card-header">

                <i class="fas fa-filter me-2"></i>
                Paramètres de l'évaluation

            </div>

            <div class="card-body">

                <div class="row align-items-end">

                    <!-- Année scolaire -->

                    <div class="col-lg-3 col-md-6 mb-3">

                        <label
                            for="anneeScolaire"
                            class="form-label"
                        >
                            Année scolaire
                        </label>

                        <select
                            class="form-select"
                            name="fk_id_anneeScolaire"
                            id="anneeScolaire"
                            required
                        >

                            <option value="">
                                -- Choisir une année --
                            </option>

                            <?php foreach($liste_annee as $annee): ?>

                                <option
                                    value="<?= $annee["Id_anneeScolaire"]; ?>"
                                    <?= $idAnneeSelectionnee == ($annee["Id_anneeScolaire"]) ? "selected" : ""?>
                                >
                                    <?= $annee["annee"]; ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <!-- Classe -->

                    <div class="col-lg-3 col-md-6 mb-3">

                        <label
                            for="classe"
                            class="form-label"
                        >
                            Classe
                        </label>

                        <select
                            class="form-select"
                            name="fk_id_classe"
                            id="classe"
                            required
                        >

                            <option value="">
                                -- Choisir une classe --
                            </option>

                            <?php foreach($liste_classe as $classe): ?>

                                <option
                                    value="<?= $classe["Id_classe"] ?>"
                                    <?= $idClasseSelectionnee == ($classe["Id_classe"]) ? "selected" : ""?>
                                >
                                    <?= $classe["nom_classe"]; ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <!-- Composition -->

                    <div class="col-lg-2 col-md-6 mb-3">

                        <label
                            for="composition"
                            class="form-label"
                        >
                            Composition
                        </label>

                        <select
                            class="form-select"
                            name="fk_id_composition"
                            id="composition"
                            disabled
                        >

                            <option value="">
                                -- Choisir --
                            </option>

                            <!--
                                Les compositions dépendront
                                de l'année scolaire choisie.
                            -->

                        </select>

                    </div>


                    <!-- Matière -->

                    <div class="col-lg-2 col-md-6 mb-3">

                        <label
                            for="matiere"
                            class="form-label"
                        >
                            Matière
                        </label>

                        <select
                            class="form-select"
                            name="fk_id_matiere"
                            id="matiere"
                            required
                        >

                            <option value="">
                                -- Choisir --
                            </option>

                            <?php foreach($liste_matiere as $matiere): ?>

                                <option
                                    value="<?= $matiere["ID_matiere"]; ?>"
                                    <?= $idMatiereSelectionnee == ($matiere["ID_matiere"]) ? "selected" : ""?>
                                >
                                    <?= $matiere["nom_matiere"]; ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <!-- Bouton charger -->

                    <div class="col-lg-2 col-md-12 mb-3 d-grid">

                        <button
                            type="submit"
                            class="btn btn-primary"
                            name="action" value="charger"
                            id="chargerEleves"
                        >

                            <i class="fas fa-search me-2"></i>
                            Charger les élèves

                        </button>

                    </div>

                </div>

            </div>

        </div>


        <!-- Tableau des élèves -->

        <div class="card">

            <div
                class="card-header d-flex justify-content-between align-items-center"
            >

                <div>

                    <i class="fas fa-users me-2"></i>
                    Élèves de la classe

                    <!-- Le nom de la classe sélectionnée sera affiché ici -->

                </div>


                <span class="badge bg-primary" id="matiereComposition">
                    Matière - Composition
                </span>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table
                        class="table table-bordered table-hover align-middle"
                    >

                        <thead class="table-light">

                            <tr>

                                <th width="70">
                                    N°
                                </th>

                                <th>
                                    Nom
                                </th>

                                <th>
                                    Prénom
                                </th>

                                <th width="170">
                                    Note /20
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php foreach($liste_eleve as $eleve): ?>

                                <tr>

                                    <td>
                                        <?= $nombre_eleve += 1; ?>
                                    </td>

                                    <td>
                                        <?= $eleve["nom_eleve"]; ?>
                                    </td>

                                    <td>
                                        <?= $eleve["prenom_eleve"]; ?>
                                    </td>

                                    <td>

                                        <input
                                            type="number"
                                            name="note[<?= $eleve["Id_eleve"]; ?>]"
                                            value="<?= $notesSaisies[$eleve["Id_eleve"]] ?? ""; ?>"
                                        >

                                    </td>

                                </tr>

                            <?php endforeach; ?>


                            <!--
                                Les élèves seront affichés ici
                                dynamiquement selon :
                                - l'année scolaire sélectionnée
                                - la classe sélectionnée
                                et seront triés par :
                                nom_eleve ASC
                                prenom_eleve ASC
                            -->

                        </tbody>

                    </table>

                </div>

            </div>


            <div class="card-footer d-flex justify-content-end">

                <a
                    href="/Gestion_Ecole_Primaire/evaluations/liste.php"
                    class="btn btn-secondary me-2"
                >
                    Retour
                </a>


                <button
                    type="submit"
                    class="btn btn-success"
                    name="action" value="enregistrer" 
                    id="enregistrerNotes"
                >

                    <i class="fas fa-save me-1"></i>
                    Enregistrer les notes

                </button>

            </div>

        </div>

    </form>

</div>

<?php include_once('../includes/footer.php'); ?>

<script>
    const anneeScolaire = document.getElementById("anneeScolaire");
    const matiere = document.getElementById("matiere");
    const composition = document.getElementById("composition");
    const matiereComposition = document.getElementById("matiereComposition");

    function mettreAJourMatiereComposition() {
        const matiereStocker = matiere.options[matiere.selectedIndex].text;
        const compositionStocker = composition.options[composition.selectedIndex].text;
        matiereComposition.textContent = matiereStocker + " - " + compositionStocker;
    }

    matiere.addEventListener("change", mettreAJourMatiereComposition);
    composition.addEventListener("change", mettreAJourMatiereComposition);

    const idCompositionSelectionnee = <?= json_encode($idCompositionSelectionnee); ?>;
    const idAnneeSelectionnee = <?= json_encode($idAnneeSelectionnee); ?>;

    function chargerCompositions(idAnnee){
        const selectComposition = document.getElementById("composition");
        selectComposition.innerHTML = '<option value="">-- Choisir une composition --</option>';
        const url = "compositions.php?id=" + idAnnee;

        fetch(url)
        .then(reponse => reponse.json())
        .then(data => {
            data.forEach(function(composition){
                    const option = document.createElement("option");
                    option.value = composition.ID_composition;
                    option.textContent = "Composition " + composition.numero;
                    if (composition.ID_composition == idCompositionSelectionnee) {
                        option.selected = true;
                    }
                    selectComposition.appendChild(option);
                })
                selectComposition.disabled = false;
                selectComposition.required = true;

                mettreAJourMatiereComposition();
            })
    }
    anneeScolaire.addEventListener("change", function(){
        const idAnnee = anneeScolaire.value;
        chargerCompositions(idAnnee);
    });

    if (idAnneeSelectionnee !== "") {
        chargerCompositions(idAnneeSelectionnee);
    }
</script>