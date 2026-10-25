
<?php
    include_once('../includes/auth_check.php');
    include_once('../configuration/connexion.php');

    // Initialisation des variables
    $nom_classe = '';
    $fk_id_enseignant = '';
    $message = null;
    $type_message = null;
    $affectationAutorisee = false;

    // Récupération de la liste des enseignants
    $rqtEnseignant = "SELECT ID_enseignant, nom_enseignant, prenom_enseignant
                      FROM ENSEIGNANT;";

    $stmtEnseignant = $connexion->prepare($rqtEnseignant);
    $stmtEnseignant->execute();
    $listeEnseignant = $stmtEnseignant->fetchAll(PDO::FETCH_ASSOC);

    // Récupération de la l'ANNEE_SCOLAIRE active
    $rqtAnneeScolaire = "SELECT Id_anneeScolaire, annee, statut
                      FROM ANNEE_SCOLAIRE
                      WHERE statut = 'active';";
    $stmtAnneeScolaire = $connexion->prepare($rqtAnneeScolaire);
    $stmtAnneeScolaire->execute();
    $anneeScolaire = $stmtAnneeScolaire->fetch(PDO::FETCH_ASSOC);
    $anneeActiveDisponible = ($anneeScolaire !== false);


    // Traitement du formulaire
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enregistrer'])) {
        if ($anneeActiveDisponible === false) {
            $message = "Aucune année scolaire n'est actuellement active. Impossible d'ajouter une classe.";
            $type_message = "danger";
        }else{

            $nom_classe = mb_strtoupper(trim($_POST['nom_classe']?? ''), 'UTF-8');
            $fk_id_enseignant = $_POST['fk_id_enseignant'] ?? '';
    
            // 1. Validation du nom de la classe
            if ($nom_classe === '' || mb_strlen($nom_classe) < 2) {
    
                $message = "Le nom de la classe doit contenir au moins deux caractères.";
                $type_message = "danger";
                $affectationAutorisee = false;
    
            } else {
    
                // 2. Vérification des doublons
                $rqtDoublon = "SELECT Id_classe
                               FROM CLASSE
                               WHERE LOWER(TRIM(nom_classe)) = LOWER(TRIM(?)) AND fk_id_anneeScolaire = ?;";
    
                $stmtDoublon = $connexion->prepare($rqtDoublon);
                $stmtDoublon->execute([$nom_classe, $anneeScolaire['Id_anneeScolaire']]);
    
                $classeExistante = $stmtDoublon->fetch(PDO::FETCH_ASSOC);
    
                if ($classeExistante !== false) {
    
                    $message = "Une classe portant ce nom existe déjà.";
                    $type_message = "danger";
    
                } else {
    
                    // 3. Vérification de l'enseignant sélectionné
                    if ($fk_id_enseignant === '') {
    
                        // L'affectation d'un enseignant est facultative
                        $fk_id_enseignant = null;
    
                    } elseif (filter_var($fk_id_enseignant, FILTER_VALIDATE_INT) !== false && (int) $fk_id_enseignant > 0) {
    
                        $rqtVerifEnseignant = "SELECT ID_enseignant
                                               FROM ENSEIGNANT
                                               WHERE ID_enseignant = ?;";
    
                        $stmtVerifEnseignant = $connexion->prepare($rqtVerifEnseignant);
    
                        $stmtVerifEnseignant->execute([$fk_id_enseignant]);
    
                        $enseignant = $stmtVerifEnseignant->fetch(PDO::FETCH_ASSOC);
    
                        if ($enseignant !== false) {
                            $rqtEnseignantAffecter = "SELECT fk_id_enseignant
                                                FROM CLASSE
                                                WHERE fk_id_enseignant = ? AND fk_id_anneeScolaire = ?;";
                            $stmtEnseignantAffecter = $connexion->prepare($rqtEnseignantAffecter);
                            $stmtEnseignantAffecter->execute([$fk_id_enseignant, $anneeScolaire['Id_anneeScolaire']]);
                            $enseignantAffecter = $stmtEnseignantAffecter->fetchColumn();
                            if ($enseignantAffecter !== false) {
                                $message = "Cet enseignant est déjà affectée dans une classe.";
                                $type_message = "danger";
                                $affectationAutorisee = false;
                            }else{
                                $affectationAutorisee = true;
                            }
    
                        } else {
                            $affectationAutorisee = false;
                            $message = "L'enseignant sélectionné n'existe pas.";
                            $type_message = "danger";
                        }
    
                    } else {
                        $affectationAutorisee = false;
                        $message = "L'identifiant de l'enseignant est incorrect.";
                        $type_message = "danger";
                    }
    
                    if ($fk_id_enseignant === null) {
                        $affectationAutorisee = true;
                    }
                        
                }
            }
        // 4. Insertion uniquement si les validations réussissent
            if ($affectationAutorisee) {
                try {
                    $connexion->beginTransaction();
            
                    $rqtAjouterClasse = "INSERT INTO CLASSE(nom_classe, fk_id_enseignant, fk_id_anneeScolaire)
                                         VALUES (?, ?, ?)";
            
                    $stmtAjouterClasse = $connexion->prepare($rqtAjouterClasse);
                    $stmtAjouterClasse->execute([$nom_classe, $fk_id_enseignant, $anneeScolaire['Id_anneeScolaire']]);
            
                                // Redirection pour éviter une nouvelle insertion
                                // lors de l'actualisation du navigateur
                    $connexion->commit();
                    $_SESSION['message'] = "Classe ajoutée avec succès.";
                    $_SESSION['type_message'] = "success";
                    header('Location: liste.php');
                    exit();
                } catch (PDOException $e) {
                    if ($connexion->inTransaction()) {
                        $connexion->rollBack();
                    }
                    $_SESSION['message'] = "Une erreur est survenue lors de l'ajout de la classe.";
                    $_SESSION['type_message'] = 'danger';
                    header("Location: ajouter.php");
                    exit();
                }
            }
        }

    }

    // Messages d'erreur à afficher sur cette page
    if ($message !== null) {
        $_SESSION['message'] = $message;
        $_SESSION['type_message'] = $type_message;
    }

    // Inclusions de l'interface après le traitement PHP
    include_once('../includes/header.php');
    include_once('../includes/navbar.php');
    include_once('../includes/sidebar.php');
?>

<div class="container-fluid px-4">

    <h1 class="mt-4">Ajouter une classe</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/index.php">Tableau de bord</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/classes/liste.php">Classes</a>
        </li>
        <li class="breadcrumb-item active">
            Ajouter une classe
        </li>
    </ol>

    <div class="card shadow-sm">

        <div class="card-header">

            <i class="fas fa-plus-circle me-2"></i>

            Nouvelle classe

        </div>

        <?php if($message): ?>
            <div class="alert alert-<?= $type_message; ?>">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <?= htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="card-body">

            <form action="#" method="post">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Nom de la classe
                        </label>

                        <input
                            type="text"
                            name="nom_classe"
                            class="form-control"
                            placeholder="Ex : CI, CP, CE1, CE2, CM1 ou CM2"
                            required
                        >

                    </div>
                
                    <div class="col-md-6 mb-3">
                        
                        <label class="form-label">
                            Enseignant titulaire
                        </label>
                        
                        <select class="form-select" name="fk_id_enseignant">
                            <option value="" selected>-- Aucun enseignant affecté --</option>
                            <?php foreach($listeEnseignant as $enseignant): ?>
                            <option value="<?= $enseignant['ID_enseignant']; ?>"><?= htmlspecialchars($enseignant['prenom_enseignant'] . " " . $enseignant['nom_enseignant']); ?></option>
                            <?php endforeach; ?>

                        </select>

                    </div>

                </div>

                <hr>

                <div class="d-flex justify-content-end">

                    <a
                        href="/Gestion_Ecole_Primaire/classes/liste.php"
                        class="btn btn-secondary me-2"
                    >
                        <i class="fas fa-arrow-left me-1"></i>
                        Retour
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                        name="enregistrer"
                    >
                        <i class="fas fa-save me-1"></i>
                        Enregistrer
                    </button>

                </div>

            </form>
 
        </div>

    </div>

</div>
<?php include_once('../includes/footer.php'); ?>