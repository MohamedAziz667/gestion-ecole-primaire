<?php
    include_once('../includes/auth_check.php');
    include_once('../configuration/connexion.php');

    $idClasse = $_GET['idClasse'] ?? '';
    $id = $_GET['id'] ?? '';
    if(!filter_var($id, FILTER_VALIDATE_INT) || $id <= 0 || !filter_var($idClasse, FILTER_VALIDATE_INT) || $idClasse <= 0){
        $_SESSION['message'] = "Identifiant invalide.";
        $_SESSION['type_message'] = "danger";
        header("Location: ../classes/detail.php?id=" . $idClasse);
        exit();
    }else{
        $rqtEleve = "SELECT E.nom_eleve, E.prenom_eleve, E.matricule, E.sexe_eleve, E.date_naissance, E.lieu_naissance, E.adresse_eleve, E.nom_tuteur, E.telephone_tuteur
                    FROM ELEVE E
                    WHERE E.ID_eleve = ?;";
        $stmtEleve = $connexion->prepare($rqtEleve);
        $stmtEleve->execute([$id]);
        $eleve = $stmtEleve->fetch(PDO::FETCH_ASSOC);
        if ($eleve === false) {
            $_SESSION['message'] = "L'élève n'existe pas.";
            $_SESSION['type_message'] = "danger";
            header("Location: ../classes/detail.php?id=" . $idClasse);
            exit();
        }else{
            if(isset($_POST['modifier_eleve'])){
                $sexe_eleve = trim($_POST['sexe_eleve']);
                $nom_eleve = trim($_POST['nom_eleve']);
                $prenom_eleve = trim($_POST['prenom_eleve']);
                $date_naissance = trim($_POST['date_naissance']);
                $lieu_naissance = trim($_POST['lieu_naissance']);
                $adresse_eleve = trim($_POST['adresse_eleve']);
                $nom_tuteur = trim($_POST['nom_tuteur'] ?? '');
                $telephone_tuteur = trim($_POST['telephone_tuteur'] ?? '');

                $donneesFormulaire = [
                    'sexe_eleve' => $sexe_eleve,
                    'nom_eleve' => $nom_eleve,
                    'prenom_eleve' => $prenom_eleve,
                    'date_naissance' => $date_naissance,
                    'lieu_naissance' => $lieu_naissance,
                    'adresse_eleve' => $adresse_eleve,
                    'nom_tuteur' => $nom_tuteur,
                    'telephone_tuteur' => $telephone_tuteur

                ];
                if(empty($nom_eleve) || mb_strlen($nom_eleve) < 2){
                    $_SESSION['message'] = "Le nom doit contenir au moins 2 caractères.";
                    $_SESSION['donneesFormulaire'] = $donneesFormulaire;
                    $_SESSION['type_message'] = "danger";    
                }elseif(empty($prenom_eleve) || mb_strlen($prenom_eleve) < 2){
                    $_SESSION['message'] = "Le prénom doit contenir au moins 2 caractères.";
                    $_SESSION['donneesFormulaire'] = $donneesFormulaire;
                    $_SESSION['type_message'] = "danger";    
                }elseif(empty($sexe_eleve) || ($sexe_eleve != 'M' && $sexe_eleve != 'F')){
                    $_SESSION['message'] = "Le sexe est obligatoire";
                    $_SESSION['donneesFormulaire'] = $donneesFormulaire;
                    $_SESSION['type_message'] = "danger";    
                }elseif(empty($date_naissance)){
                    $_SESSION['message'] = "La date de naissance est obligatoire.";
                    $_SESSION['donneesFormulaire'] = $donneesFormulaire;
                    $_SESSION['type_message'] = "danger";    
                }elseif(empty($lieu_naissance) || mb_strlen($lieu_naissance) < 2){
                    $_SESSION['message'] = "Le lieu de naissance doit contenir au moins 2 caractères.";
                    $_SESSION['donneesFormulaire'] = $donneesFormulaire;
                    $_SESSION['type_message'] = "danger";    
                }elseif(empty($adresse_eleve) || mb_strlen($adresse_eleve) < 2){
                    $_SESSION['message'] = "L'adresse doit contenir au moins 2 caractères.";
                    $_SESSION['donneesFormulaire'] = $donneesFormulaire;
                    $_SESSION['type_message'] = "danger";    
                }else{
                    try {
                        $connexion->beginTransaction();
                        $rqtModifierEleve = "UPDATE ELEVE SET nom_eleve = ?, prenom_eleve = ?, sexe_eleve = ?, date_naissance = ?, lieu_naissance = ?, adresse_eleve = ?, nom_tuteur = ?, telephone_tuteur = ?
                                            WHERE ID_eleve = ?;";
                        $stmtModifierEleve = $connexion->prepare($rqtModifierEleve);
                        $stmtModifierEleve->execute([$nom_eleve, $prenom_eleve, $sexe_eleve, $date_naissance, $lieu_naissance, $adresse_eleve, $nom_tuteur, $telephone_tuteur, $id]);
                        $connexion->commit();
                        $_SESSION['message'] = "La modification a été éffectuée avec succès";
                        $_SESSION['type_message'] = "success";
                        unset($_SESSION['donneesFormulaire']);
                        header("Location: ../classes/detail.php?id=" . $idClasse);
                        exit();
                    } catch (PDOException $e) {
                        if ($connexion->inTransaction()) {
                            $connexion->rollBack();
                        }
                        $_SESSION['message'] = "Une erreur est survenue lors de la modification.";
                        $_SESSION['type_message'] = 'danger';
                        header("Location: ../classes/detail.php?id=" . $idClasse);
                        exit();
                    }
                }

            }
        }

                    
    }

    $message = $_SESSION['message'] ?? null;
    $type_message = $_SESSION['type_message'] ?? null;

    unset($_SESSION['message'], $_SESSION['type_message']);

    include_once('../includes/header.php');
    include_once('../includes/navbar.php');
    include_once('../includes/sidebar.php');
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Modifier un élève</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/index.php">Tableau de bord</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/classes/liste.php">Classes</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/classes/detail.php?id=<?= $idClasse; ?>">Détails</a>
        </li>
        <li class="breadcrumb-item active">Modifier un élève</li>
    </ol>

    <?php if($message): ?>
        <div class="alert alert-<?= $type_message; ?>">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?= htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user-edit me-1"></i>
            Informations personnelles de l'élève
        </div>

        <div class="card-body">
            <form method="POST" action="">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="matricule" class="form-label">Matricule</label>
                        <input
                            type="text"
                            class="form-control"
                            id="matricule"
                            value="<?= htmlspecialchars($eleve['matricule'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                            readonly
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="sexe_eleve" class="form-label">Sexe</label>
                        <select class="form-select" id="sexe_eleve" name="sexe_eleve" required>
                            <option value="M" <?= ($donneesFormulaire['sexe_eleve'] ?? $eleve['sexe_eleve']) === 'M' ? 'selected' : '' ; ?>>Masculin</option>
                            <option value="F" <?= ($donneesFormulaire['sexe_eleve'] ?? $eleve['sexe_eleve']) === 'F' ? 'selected' : '' ?>>Féminin</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nom_eleve" class="form-label">Nom</label>
                        <input
                            type="text"
                            class="form-control"
                            id="nom_eleve"
                            name="nom_eleve"
                            value="<?= htmlspecialchars($donneesFormulaire['nom_eleve'] ?? $eleve['nom_eleve'], ENT_QUOTES, 'UTF-8'); ?>"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="prenom_eleve" class="form-label">Prénom(s)</label>
                        <input
                            type="text"
                            class="form-control"
                            id="prenom_eleve"
                            name="prenom_eleve"
                            value="<?= htmlspecialchars($donneesFormulaire['prenom_eleve'] ?? $eleve['prenom_eleve'], ENT_QUOTES, 'UTF-8'); ?>"
                            required
                        >
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="date_naissance" class="form-label">Date de naissance</label>
                        <input
                            type="date"
                            class="form-control"
                            id="date_naissance"
                            name="date_naissance"
                            value="<?= htmlspecialchars($donneesFormulaire['date_naissance'] ?? $eleve['date_naissance'], ENT_QUOTES, 'UTF-8'); ?>"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="lieu_naissance" class="form-label">Lieu de naissance</label>
                        <input
                            type="text"
                            class="form-control"
                            id="lieu_naissance"
                            name="lieu_naissance"
                            value="<?= htmlspecialchars($donneesFormulaire['lieu_naissance'] ?? $eleve['lieu_naissance'], ENT_QUOTES, 'UTF-8'); ?>"
                            required
                        >
                    </div>
                </div>

                <div class="mb-3">
                    <label for="adresse_eleve" class="form-label">Adresse</label>
                    <input
                        type="text"
                        class="form-control"
                        id="adresse_eleve"
                        name="adresse_eleve"
                        value="<?= htmlspecialchars($donneesFormulaire['adresse_eleve'] ?? $eleve['adresse_eleve'], ENT_QUOTES, 'UTF-8'); ?>"
                        required
                    >
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nom_tuteur" class="form-label">Nom du tuteur</label>
                        <input
                            type="text"
                            class="form-control"
                            id="nom_tuteur"
                            name="nom_tuteur"
                            value="<?= htmlspecialchars($donneesFormulaire['nom_tuteur'] ?? $eleve['nom_tuteur'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="telephone_tuteur" class="form-label">Téléphone du tuteur</label>
                        <input
                            type="tel"
                            class="form-control"
                            id="telephone_tuteur"
                            name="telephone_tuteur"
                            value="<?= htmlspecialchars($donneesFormulaire['telephone_tuteur'] ?? $eleve['telephone_tuteur'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                        >
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="/Gestion_Ecole_Primaire/classes/detail.php?id=<?= $idClasse; ?>"
                       class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Annuler
                    </a>

                    <button type="submit" name="modifier_eleve" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once('../includes/footer.php'); ?>