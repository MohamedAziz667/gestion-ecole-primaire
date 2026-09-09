<?php
    include_once('../includes/auth_check.php');
    include_once('../includes/header.php');
    include_once('../includes/navbar.php');
    include_once('../includes/sidebar.php');
    include_once('../configuration/connexion.php');

    $rqtEleve = "SELECT E.* ,C.nom_classe, A.annee
                FROM eleve E
                JOIN inscription I ON E.Id_eleve = I.fk_id_eleve
                JOIN classe C ON I.fk_id_classe = C.Id_classe
                JOIN annee_scolaire A ON I.fk_id_anneeScolaire = A.Id_anneeScolaire
                WHERE I.fk_id_anneeScolaire = (
                    SELECT A.Id_anneeScolaire
                    FROM annee_scolaire A
                    ORDER BY CAST(SUBSTRING(A.annee, 1, 4) AS UNSIGNED) DESC
                    LIMIT 1
                );";
    $stmtEleve = $connexion->prepare($rqtEleve);
    $stmtEleve->execute();
    $liste_eleve = $stmtEleve->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($liste_eleve);

    $rqtClasse = "SELECT * FROM CLASSE;";
    $stmtClasse = $connexion->prepare($rqtClasse);
    $stmtClasse->execute();
    $liste_classe = $stmtClasse->fetchAll();
    // var_dump($liste_classe);

    $rqtAnnee = "SELECT * FROM ANNEE_SCOLAIRE;";
    $stmtAnnee = $connexion->prepare($rqtAnnee);
    $stmtAnnee->execute();
    $liste_annee = $stmtAnnee->fetchAll();
?>
<div class="container-fluid px-4">

    <h1 class="mt-4">Nouvelle inscription</h1>

    <ol class="breadcrumb mb-4">

        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/index.php">
                Tableau de bord
            </a>
        </li>

        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/inscriptions/liste.php">
                Inscriptions
            </a>
        </li>

        <li class="breadcrumb-item active">
            Ajouter
        </li>

    </ol>



    <form action="#" method="POST">

        <!-- ========================= -->
        <!-- TYPE D'INSCRIPTION -->
        <!-- ========================= -->

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                <i class="fas fa-user-check me-2"></i>

                Type d'inscription

            </div>

            <div class="card-body">

                <div class="form-check mb-2">

                    <input
                        class="form-check-input"
                        type="radio"
                        name="type_inscription"
                        id="ancien"
                        value="ancien"
                        checked
                    >

                    <label
                        class="form-check-label"
                        for="ancien"
                    >

                        Élève déjà enregistré

                    </label>

                </div>



                <div class="form-check">

                    <input
                        class="form-check-input"
                        type="radio"
                        name="type_inscription"
                        id="nouveau"
                        value="nouveau"
                    >

                    <label
                        class="form-check-label"
                        for="nouveau"
                    >

                        Nouvel élève

                    </label>

                </div>

            </div>

        </div>





        <!-- ========================= -->
        <!-- INFORMATIONS ÉLÈVE -->
        <!-- ========================= -->

        <div class="card shadow-sm mb-4">

    <div class="card-header">

        <i class="fas fa-user-graduate me-2"></i>

        Informations de l'élève

    </div>

    <div class="card-body">

        <!-- Élève existant -->
        <div class="mb-4" id="zoneEleveExistant">

            <!-- Recherche -->
            <div class="mb-3">

                <label class="form-label">
                    Rechercher un élève
                </label>

                <input
                    id="rechercheEleve"
                    type="text"
                    class="form-control"
                    placeholder="Saisir un nom ou un prénom"
                >

            </div>

            <!-- Liste des élèves -->
            <label class="form-label">

                Élève existant

            </label>

            <select
                class="form-select"
                name="fk_id_eleve"
                id="selectEleve"
            >

                <option value="">
                    -- Sélectionner un élève --
                </option>

                <?php foreach($liste_eleve as $eleve): ?>

                    <option
                        value="<?= $eleve['Id_eleve']; ?>"
                        data-nom="<?= $eleve['nom_eleve']; ?>"
                        data-prenom="<?= $eleve['prenom_eleve']; ?>"
                        data-sexe="<?= $eleve['sexe_eleve']; ?>"
                        data-adresse="<?= $eleve['adresse_eleve']; ?>"
                        data-date_naissance="<?= $eleve['date_naissance']; ?>"
                    >

                        <?= $eleve['nom_eleve'] . " " . $eleve['prenom_eleve'] . " - " . $eleve['nom_classe'] . " - " . $eleve['annee']; ?>

                    </option>

                <?php endforeach; ?>

            </select>

        </div>

        <hr>

        <!-- Informations de l'élève -->
        <div class="row" id="zoneInformationsEleve">

            <!-- Nom -->
            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Nom
                </label>

                <input
                    id="nomEleve"
                    type="text"
                    class="form-control"
                    name="nom_eleve"
                >

            </div>

            <!-- Prénom -->
            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Prénom
                </label>

                <input
                    id="prenomEleve"
                    type="text"
                    class="form-control"
                    name="prenom_eleve"
                >

            </div>

            <!-- Sexe -->
            <div class="col-md-4 mb-3">

                <label class="form-label">
                    Sexe
                </label>

                <select
                    id="sexeEleve"
                    class="form-select"
                    name="sexe_eleve"
                >

                    <option value="">
                        Choisir
                    </option>

                    <option value="M">
                        Masculin
                    </option>

                    <option value="F">
                        Féminin
                    </option>

                </select>

            </div>

            <!-- Date de naissance -->
            <div class="col-md-4 mb-3">

                <label class="form-label">
                    Date de naissance
                </label>

                <input
                    id="dateNaissance"
                    type="date"
                    class="form-control"
                    name="date_naissance"
                >

            </div>

            <!-- Adresse -->
            <div class="col-md-4 mb-3">

                <label class="form-label">
                    Adresse
                </label>

                <input
                    id="adresseEleve"
                    type="text"
                    class="form-control"
                    name="adresse_eleve"
                >

            </div>

        </div>

    </div>

</div>

        <!-- ========================= -->
        <!-- INSCRIPTION -->
        <!-- ========================= -->

        <div class="card shadow-sm">

            <div class="card-header">

                <i class="fas fa-school me-2"></i>

                Informations d'inscription

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Classe

                        </label>

                        <select
                            class="form-select"
                            name="fk_id_classe"
                            required
                        >

                            <option value="">
                                Choisir une classe
                            </option>
                            <?php foreach($liste_classe as $classe): ?>
                                <option value="<?= $classe['Id_classe']; ?>">
                                    <?= $classe['nom_classe']; ?>
                                </option>
                            <?php endforeach; ?>

                        </select>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Année scolaire

                        </label>

                        <select
                            class="form-select"
                            name="fk_id_anneeScolaire"
                            required
                        >

                            <option value="">
                                Choisir une année
                            </option>

                            <?php foreach($liste_annee as $annee): ?>
                                <option value="<?= $annee['Id_anneeScolaire']; ?>">
                                    <?= $annee['annee']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Statut

                        </label>

                        <select
                            class="form-select"
                            name="statut"
                            required
                        >

                            <option value="admis">
                                Admis
                            </option>

                            <option value="ajourne">
                                Ajourné
                            </option>

                        </select>

                    </div>

                </div>

            </div>

            <div class="card-footer text-end">

                <a
                    href="/Gestion_Ecole_Primaire/inscriptions/liste.php"
                    class="btn btn-secondary"
                >

                    Retour

                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                    name="enregistrer_inscription"
                >

                    <i class="fas fa-save me-1"></i>

                    Enregistrer l'inscription

                </button>

            </div>

        </div>

    </form>

</div>
<script>
    const ancien = document.getElementById("ancien");
    const nouveau = document.getElementById("nouveau");

    const zoneEleveExistant = document.getElementById("zoneEleveExistant");
    const zoneInformationsEleve = document.getElementById("zoneInformationsEleve");

    const selectEleve = document.getElementById("selectEleve");
    const nomEleve = document.getElementById("nomEleve")
    const prenomEleve = document.getElementById("prenomEleve")
    const sexeEleve = document.getElementById("sexeEleve");
    const adresseEleve = document.getElementById("adresseEleve");
    const dateNaissance = document.getElementById("dateNaissance");

    const rechercheEleve = document.getElementById("rechercheEleve");

    ancien.addEventListener("change", function(){
        zoneInformationsEleve.style.display = "";
        zoneEleveExistant.style.display = "";
    });

    nouveau.addEventListener("change", function(){
        zoneEleveExistant.style.display = "none";
        zoneInformationsEleve.style.display = "";
        nomEleve.value = "";
        prenomEleve.value = "";
        sexeEleve.value = "";
        adresseEleve.value = "";
        dateNaissance.value = "";
        selectEleve.value = "";

        nomEleve.readOnly = false;
        prenomEleve.readOnly = false;
        sexeEleve.disabled = false;
        adresseEleve.readOnly = false;
        dateNaissance.readOnly = false;
    });

    selectEleve.addEventListener("change", function(){
        console.log(selectEleve.value);
        const eleveSelectionne = selectEleve.options[selectEleve.selectedIndex];
        nomEleve.value = eleveSelectionne.dataset.nom;
        nomEleve.readOnly = true;
        prenomEleve.value = eleveSelectionne.dataset.prenom;
        prenomEleve.readOnly = true;
        sexeEleve.value = eleveSelectionne.dataset.sexe;
        sexeEleve.disabled = true;
        adresseEleve.value = eleveSelectionne.dataset.adresse;
        adresseEleve.readOnly = true;
        dateNaissance.value = eleveSelectionne.dataset.date_naissance;
        dateNaissance.readOnly = true;
        console.log("Élève changé");
    });

    rechercheEleve.addEventListener("input", function(){
       const options = selectEleve.getElementsByTagName("option");
       for(option of options){
        const correspond = option.textContent.toLowerCase().includes(rechercheEleve.value.toLowerCase());
        if (correspond == true) {
            option.style.display = "";
        } else {
            option.style.display = "none";
        }
       }
    });
</script>
<?php include_once('../includes/footer.php'); ?>