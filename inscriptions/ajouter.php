<?php
    include_once('../includes/auth_check.php');
    include_once('../includes/header.php');
    include_once('../includes/navbar.php');
    include_once('../includes/sidebar.php');
    include_once('../configuration/connexion.php');
    $message = $_SESSION['message'] ?? null;
    unset($_SESSION['message']);

    $ancien_formulaire = $_SESSION['ancien_formulaire'] ?? [];
    unset($_SESSION['ancien_formulaire']);

    $type_message = $_SESSION['type_message'] ?? '';
    unset($_SESSION['type_message']);

    $rqtEleve = "SELECT I.fk_id_eleve, E.nom_eleve, E.prenom_eleve, E.sexe_eleve, E.adresse_eleve, E.date_naissance, E.lieu_naissance, E.nom_tuteur, E.telephone_tuteur, C.nom_classe, A.annee
                    FROM inscription I
                    JOIN (
                        SELECT fk_id_eleve, MAX(fk_id_anneeScolaire) AS derniere_annee
                        FROM inscription
                        GROUP BY fk_id_eleve
                    ) D
                    ON I.fk_id_eleve = D.fk_id_eleve AND I.fk_id_anneeScolaire = D.derniere_annee
                    JOIN classe C
                    ON I.fk_id_classe = C.Id_classe
                    JOIN annee_scolaire A
                    ON I.fk_id_anneeScolaire = A.Id_anneeScolaire
                    JOIN eleve E
                    ON I.fk_id_eleve = E.Id_eleve;";
    $stmtEleve = $connexion->prepare($rqtEleve);
    $stmtEleve->execute();
    $liste_eleve = $stmtEleve->fetchAll(PDO::FETCH_ASSOC);

    $rqtClasse = "SELECT * FROM CLASSE;";
    $stmtClasse = $connexion->prepare($rqtClasse);
    $stmtClasse->execute();
    $liste_classe = $stmtClasse->fetchAll();

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

    <?php if($message): ?>
        <div class="alert alert-<?= $type_message; ?>"> 
        <?= $message; ?> </div> 
    <?php endif; ?>


    <form id="formInscription" action="../traitements/traiter_ajout_inscription.php" method="POST" novalidate>

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
                        <?= (($ancien_formulaire['type_inscription'] ?? 'ancien') === 'ancien') ? 'checked' : ''; ?>
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
                        <?= (($ancien_formulaire['type_inscription'] ?? '') === 'nouveau') ? 'checked' : ''; ?>
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
                        value="<?= htmlspecialchars((string)$eleve['fk_id_eleve']); ?>"
                        data-nom="<?= htmlspecialchars($eleve['nom_eleve'], ENT_QUOTES, 'UTF-8'); ?>"
                        data-prenom="<?= htmlspecialchars($eleve['prenom_eleve'], ENT_QUOTES, 'UTF-8'); ?>"
                        data-sexe="<?= htmlspecialchars($eleve['sexe_eleve'], ENT_QUOTES, 'UTF-8'); ?>"
                        data-adresse="<?= htmlspecialchars($eleve['adresse_eleve'], ENT_QUOTES, 'UTF-8'); ?>"
                        data-date_naissance="<?= htmlspecialchars($eleve['date_naissance'], ENT_QUOTES, 'UTF-8'); ?>"
                        data-lieu_naissance="<?= htmlspecialchars($eleve['lieu_naissance'], ENT_QUOTES, 'UTF-8'); ?>"
                        data-nom_tuteur="<?= htmlspecialchars($eleve['nom_tuteur'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                        data-telephone_tuteur="<?= htmlspecialchars($eleve['telephone_tuteur'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                        <?= (string)($ancien_formulaire['fk_id_eleve'] ?? '') === (string)$eleve['fk_id_eleve'] ? 'selected' : ''; ?>
                    >
                        <?= htmlspecialchars($eleve['nom_eleve'] . ' ' . $eleve['prenom_eleve'] . ' - ' . $eleve['nom_classe'] . ' - ' . $eleve['annee'], ENT_QUOTES, 'UTF-8'); ?>
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
                    value="<?= htmlspecialchars($ancien_formulaire['nom_eleve'] ?? ''); ?>"
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
                    value="<?= htmlspecialchars($ancien_formulaire['prenom_eleve'] ?? ''); ?>"
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
                    value="<?= htmlspecialchars($ancien_formulaire['sexe_eleve'] ?? ''); ?>"
                    id="sexeEleve"
                    class="form-select"
                    name="sexe_eleve"
                >

                    <option value="">
                        Choisir
                    </option>

                    <option value="M"
                            <?= (($ancien_formulaire['sexe_eleve'] ?? '') === 'M') ? 'selected' : ''; ?>>
                        Masculin
                    </option>

                    <option value="F"
                            <?= (($ancien_formulaire['sexe_eleve'] ?? '') === 'F') ? 'selected' : ''; ?>>
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
                    value="<?= htmlspecialchars($ancien_formulaire['date_naissance'] ?? ''); ?>"
                    id="dateNaissance"
                    type="date"
                    class="form-control"
                    name="date_naissance"
                >

            </div>

            <!-- Lieu de naissance -->
            <div class="col-md-4 mb-3">
                <label class="form-label">
                    Lieu de naissance
                </label>

                <input
                    value="<?= htmlspecialchars($ancien_formulaire['lieu_naissance'] ?? ''); ?>"
                    id="lieuNaissance"
                    type="text"
                    class="form-control"
                    name="lieu_naissance"
                    required
                >
            </div>

            <!-- Adresse -->
            <div class="col-md-4 mb-3">

                <label class="form-label">
                    Adresse
                </label>

                <input
                    value="<?= htmlspecialchars($ancien_formulaire['adresse_eleve'] ?? ''); ?>"
                    id="adresseEleve"
                    type="text"
                    class="form-control"
                    name="adresse_eleve"
                >

            </div>

            <!-- Informations du tuteur -->
            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Nom et prénom du parent/tuteur
                </label>

                <input
                    value="<?= htmlspecialchars($ancien_formulaire['nom_tuteur'] ?? ''); ?>"
                    id="nom_tuteur"
                    type="text"
                    class="form-control"
                    name="nom_tuteur"
                    placeholder="Ex : Abdoulaye Touré"
                >

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Téléphone du parent/tuteur
                </label>

                <input
                    value="<?= htmlspecialchars($ancien_formulaire['telephone_tuteur'] ?? ''); ?>"
                    id="telephone_tuteur"
                    type="text"
                    class="form-control"
                    name="telephone_tuteur"
                    placeholder="Ex : 77 123 45 67"
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
                            id="fk_id_classe"
                            required
                        >

                            <option value="">
                                Choisir une classe
                            </option>
                            <?php foreach($liste_classe as $classe): ?>
                                <option value="<?= $classe['Id_classe']; ?>"
                                    <?= (string)($ancien_formulaire['fk_id_classe'] ?? '') === (string)$classe['Id_classe'] ? 'selected' : '' ; ?>>
                                    <?= htmlspecialchars($classe['nom_classe']); ?>
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
                            id="fk_id_anneeScolaire"
                            required
                        >

                            <option value="">
                                Choisir une année
                            </option>

                            <?php foreach($liste_annee as $annee): ?>
                                <option value="<?= $annee['Id_anneeScolaire']; ?>"
                                    <?= (string)($annee['Id_anneeScolaire']) === (string)($ancien_formulaire['fk_id_anneeScolaire'] ?? '') ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($annee['annee']); ?>
                                </option>
                            <?php endforeach; ?>
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
    const optionsOriginales = Array.from(selectEleve.options).slice(1);
    // console.log("Options originales :", optionsOriginales.length);
    const nomEleve = document.getElementById("nomEleve")
    const prenomEleve = document.getElementById("prenomEleve")
    const sexeEleve = document.getElementById("sexeEleve");
    const adresseEleve = document.getElementById("adresseEleve");
    const dateNaissance = document.getElementById("dateNaissance");
    const lieuNaissance = document.getElementById("lieuNaissance");
    const nom_tuteur = document.getElementById("nom_tuteur");
    const telephone_tuteur = document.getElementById("telephone_tuteur");

    const rechercheEleve = document.getElementById("rechercheEleve");

    const formInscription = document.getElementById("formInscription");
    

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
        lieuNaissance.value = "";
        nom_tuteur.value = "";
        telephone_tuteur.value = "";
        selectEleve.value = "";

        nomEleve.readOnly = false;
        prenomEleve.readOnly = false;
        sexeEleve.disabled = false;
        adresseEleve.readOnly = false;
        dateNaissance.readOnly = false;
        lieuNaissance.readOnly = false;
    });

    selectEleve.addEventListener("change", function(){
    
        const eleveSelectionne = selectEleve.options[selectEleve.selectedIndex];
        if (!selectEleve.value) {
            return;
        }
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
        lieuNaissance.value = eleveSelectionne.dataset.lieu_naissance;
        lieuNaissance.readOnly = true;
        nom_tuteur.value = eleveSelectionne.dataset.nom_tuteur;
        telephone_tuteur.value = eleveSelectionne.dataset.telephone_tuteur;
        // console.log("Élève changé");
    });

    if (ancien.checked && selectEleve.value !== "") {
        remplirInformationsEleve();
    }

    rechercheEleve.addEventListener("input", function(){
        console.log("Recherche :", rechercheEleve.value);
        selectEleve.innerHTML = "";
        const optionVide = document.createElement("option");
        optionVide.value = "";
        optionVide.textContent = "-- Sélectionner un élève --";
        selectEleve.appendChild(optionVide);
       for(const option of optionsOriginales){
        console.log("Option :", option.textContent);
        const correspond = option.textContent.toLowerCase().includes(rechercheEleve.value.toLowerCase());
        if(correspond === true){
            console.log("Élève trouvé :", option.textContent);
            selectEleve.appendChild(option.cloneNode(true));
        }
        if(rechercheEleve.value.trim() !== ""){
            selectEleve.selectedIndex = 1;
            selectEleve.dispatchEvent(new Event("change"));
        }else{
            nomEleve.value = "";
            prenomEleve.value = "";
            sexeEleve.value = "";
            adresseEleve.value = "";
            dateNaissance.value = "";
        }
       }
      
    });
</script>
<?php include_once('../includes/footer.php'); ?>