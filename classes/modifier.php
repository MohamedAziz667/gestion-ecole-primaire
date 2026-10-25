<?php
    include_once('../includes/auth_check.php');
    include_once('../configuration/connexion.php');

    $message = $_SESSION['message'] ?? null;
    $type_message = $_SESSION['type_message'] ?? null;

    unset($_SESSION['message'], $_SESSION['type_message']);

    $id = $_GET['id'] ?? '';
    
    if(!filter_var($id, FILTER_VALIDATE_INT) || $id <= 0){
        $_SESSION['message'] = "Identifiant invalide.";
        $_SESSION['type_message'] = "danger";
        header("Location: liste.php");
        exit();
        }else{
            $id = (int) $id;
            $rqtClasse = "SELECT C.Id_classe, C.nom_classe, C.fk_id_enseignant, C.fk_id_anneeScolaire, A.statut
                        FROM CLASSE C
                        INNER JOIN ANNEE_SCOLAIRE A ON C.fk_id_anneeScolaire = A.Id_anneeScolaire
                        WHERE C.Id_classe = ?;";
            $stmtClasse = $connexion->prepare($rqtClasse);
            $stmtClasse->execute([$id]);
            $classe = $stmtClasse->fetch(PDO::FETCH_ASSOC);
            if($classe === false){
                $_SESSION['message'] = "Classe introuvable.";
                $_SESSION['type_message'] = "danger";
                header("Location: liste.php");
                exit();
        }else{
            if($classe['statut'] !== 'active'){
                $_SESSION['message'] = "Impossible de modifier une classe appartenant à une année scolaire non active.";
                $_SESSION['type_message'] = "danger";
                header("Location: liste.php");
                exit();
            }
            $rqtEnseignant = "  SELECT e.ID_enseignant, e.nom_enseignant, e.prenom_enseignant
                                FROM ENSEIGNANT e
                                WHERE NOT EXISTS (
                                    SELECT 1
                                    FROM CLASSE c
                                    WHERE c.fk_id_enseignant = e.ID_enseignant
                                    AND c.Id_classe <> ? AND c.fk_id_anneeScolaire = ?);";
            $stmtEnseignant = $connexion->prepare($rqtEnseignant);
            $stmtEnseignant->execute([$id, $classe['fk_id_anneeScolaire']]);
            $listeEnseignant = $stmtEnseignant->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    $trouve = false;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $rqtProtection = "SELECT A.statut
                        FROM CLASSE C
                        INNER JOIN ANNEE_SCOLAIRE A ON C.fk_id_anneeScolaire = A.Id_anneeScolaire
                        WHERE C.Id_classe = ?;";
        $stmtProtection = $connexion->prepare($rqtProtection);
        $stmtProtection->execute([$id]);
        $protection = $stmtProtection->fetch(PDO::FETCH_ASSOC);

        if($protection === false){
                $_SESSION['message'] = "Classe introuvable.";
                $_SESSION['type_message'] = "danger";
                header("Location: liste.php");
                exit();
        }elseif($protection['statut'] !== 'active'){
                $_SESSION['message'] = "Impossible de modifier une classe appartenant à une année scolaire non active.";
                $_SESSION['type_message'] = "danger";
                header("Location: liste.php");
                exit();
        }
        
        $nom_classe = mb_strtoupper(trim($_POST['nom_classe']?? ''), 'UTF-8');
        $fk_id_enseignant = $_POST['fk_id_enseignant'] ?? '';
        $fk_id_enseignant = ($fk_id_enseignant === '') ? null : $fk_id_enseignant;

        if ($nom_classe === '' || mb_strlen($nom_classe) < 2) {
            $message = "Le nom de la classe doit contenir au moins deux caractères.";
            $type_message = "danger";

        } else {
            $rqtDoublon = "SELECT Id_classe
                           FROM CLASSE
                           WHERE LOWER(TRIM(nom_classe)) = LOWER(TRIM(?)) AND Id_classe <> ? AND fk_id_anneeScolaire = ?;";
            $stmtDoublon = $connexion->prepare($rqtDoublon);
            $stmtDoublon->execute([$nom_classe, $id, $classe['fk_id_anneeScolaire']]);
            $classeExistante = $stmtDoublon->fetch(PDO::FETCH_ASSOC);

            if ($classeExistante !== false) {
                $message = "Une classe portant ce nom existe déjà.";
                $type_message = "danger";
            }else{

                if ($fk_id_enseignant === null) {
                    $trouve = true;
                }else{
                    $idEnseignantValide = filter_var($fk_id_enseignant, FILTER_VALIDATE_INT);

                    if ($idEnseignantValide === false || $idEnseignantValide <= 0) {
                        $message = "Identifiant de l'enseignant invalide.";
                        $type_message = "danger";
                        $trouve = false;
                    } else {
                        $rqtEnseignant = "SELECT e.ID_enseignant
                        FROM ENSEIGNANT e
                        WHERE e.ID_enseignant = ?
                        AND NOT EXISTS (
                            SELECT 1
                            FROM CLASSE c
                            WHERE c.fk_id_enseignant = e.ID_enseignant
                            AND c.Id_classe <> ? AND c.fk_id_anneeScolaire = ?);";
    
                        $stmtEnseignant = $connexion->prepare($rqtEnseignant);
                        $stmtEnseignant->execute([$idEnseignantValide, $id, $classe['fk_id_anneeScolaire']]);
                        $resultatEnseignant = $stmtEnseignant->fetch(PDO::FETCH_ASSOC);
                    
                        if($resultatEnseignant === false){
                            $message = "Cet enseignant n'existe pas ou est déjà affecté à une autre classe.";
                            $type_message = "danger";
                            $trouve = false;
                        }else{
                            $trouve = true;
                        }
                    }
                }

            }
        }
        if($trouve === true){
            try {
                $connexion->beginTransaction();
                $rqtModifierClasse = "UPDATE CLASSE SET nom_classe = ?, fk_id_enseignant = ? WHERE Id_classe = ?";
                            $stmtModifierClasse = $connexion->prepare($rqtModifierClasse);
                            $stmtModifierClasse->execute([$nom_classe, $fk_id_enseignant, $id]);
                            $connexion->commit();
                            $_SESSION['message'] = "Classe modifiée avec succès.";
                            $_SESSION['type_message'] = "success";
                            header("Location: liste.php");
                            exit();
            } catch (PDOException $e) {
                if ($connexion->inTransaction()) {
                    $connexion->rollBack();
                }
                $_SESSION['message'] = "Une erreur est survenue lors de la modification.";
                $_SESSION['type_message'] = 'danger';
                header("Location: liste.php");
                exit();
            }
        }
            }
    

    include_once('../includes/header.php');
    include_once('../includes/navbar.php');
    include_once('../includes/sidebar.php');
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Modifier une classe</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/index.php">Tableau de bord</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/classes/liste.php">Classes</a>
        </li>
        <li class="breadcrumb-item active">Modifier une classe</li>
    </ol>

    <?php if($message): ?>
        <div class="alert alert-<?= $type_message; ?>">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?= htmlspecialchars($message); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    <?php endif; ?>

    <!-- Carte du formulaire -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Informations de la classe
        </div>

        <div class="card-body">

            <!-- Les messages de session seront affichés ici -->

            <form method="POST"
                  action=""
                  class="needs-validation"
                  novalidate>

                <!-- Nom de la classe -->
                <div class="mb-3">
                    <label for="nom_classe" class="form-label">
                        Nom de la classe
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="nom_classe"
                        name="nom_classe"
                        placeholder="Ex. : CM1A"
                        required
                        minlength="2"
                        value="<?= htmlspecialchars($nom_classe ?? $classe['nom_classe'], ENT_QUOTES, 'UTF-8'); ?>"
                    >
                

                    <div class="invalid-feedback">
                        Veuillez saisir un nom de classe d'au moins deux caractères.
                    </div>
                </div>

                <!-- Affectation de l'enseignant -->
                <div class="mb-3">
                    <label for="fk_id_enseignant" class="form-label">
                        Enseignant affecté
                    </label>

                    <select
                        class="form-select"
                        id="fk_id_enseignant"
                        name="fk_id_enseignant"
                    >
                        <option value="">
                            -- Aucun enseignant affecté --
                        </option>

                        <?php foreach($listeEnseignant as $enseignant): ?>
                            <option value="<?= $enseignant['ID_enseignant']; ?>" <?= (string) $enseignant['ID_enseignant'] === (string) ($fk_id_enseignant ?? $classe['fk_id_enseignant']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($enseignant['prenom_enseignant'] . " " . $enseignant["nom_enseignant"], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <div class="form-text">
                        Vous pouvez conserver l'enseignant actuel,
                        en choisir un autre ou retirer l'affectation.
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="d-flex justify-content-between mt-4">
                    <a
                        href="/Gestion_Ecole_Primaire/classes/liste.php"
                        class="btn btn-secondary"
                    >
                        <i class="fas fa-arrow-left me-1"></i>
                        Annuler
                    </a>

                    <button
                        type="submit"
                        name="modifier"
                        class="btn btn-primary"
                    >
                        <i class="fas fa-save me-1"></i>
                        Enregistrer les modifications
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
<?php include_once('../includes/footer.php'); ?>