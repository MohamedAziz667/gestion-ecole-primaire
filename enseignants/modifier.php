<?php
    include_once('../includes/auth_check.php');
    include_once('../includes/header.php');
    include_once('../includes/navbar.php');
    include_once('../includes/sidebar.php');
    include_once('../configuration/connexion.php');

    $ancien_formulaire = $_SESSION['ancien_formulaire'] ?? [];
    unset($_SESSION['ancien_formulaire']);

    $message = $_SESSION['message'] ?? null;
    unset($_SESSION['message']);

    $type_message = $_SESSION['type_message'] ?? '';
    unset($_SESSION['type_message']);

    $id = $_GET['id'];
    $rqtEnseignant = "SELECT E.ID_enseignant, E.nom_enseignant, E.prenom_enseignant, E.matricule, E.email, E.date_naissance, E.lieu_naissance, E.grade, E.telephone
                        FROM ENSEIGNANT E
                        WHERE E.ID_enseignant = ?;";
    $stmtEnseignant = $connexion->prepare($rqtEnseignant);
    $stmtEnseignant->execute([$id]);
    $enseignant = $stmtEnseignant->fetch(PDO::FETCH_ASSOC);
    // var_dump($enseignant);
    
    if ($enseignant === false) {
        echo "Enseignant introuvable";
        exit();
    }else{
        // $rqtModifier = "UPDATE ENSEIGNANT SET nom_enseignant = ?, prenom_enseignant = ?, matricule = ?, email = ? WHERE E.ID_enseignant = ?;";
        // $stmtModifier = $connexion->prepare($rqtModifier);
        // $stmtModifier->execute([]);
    }
?>

<div class="container-fluid px-4">

    <h1 class="mt-4">Modifier un enseignant</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/index.php">Tableau de bord</a>
        </li>

        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/enseignants/liste.php">
                Enseignants
            </a>
        </li>

        <li class="breadcrumb-item active">
            Modifier
        </li>
    </ol>
     <div class="card mb-4">
        <?php if($type_message): ?>
            <div class="alert alert-<?= $type_message; ?>">
                <?= htmlspecialchars($message ?? ''); ?>
            </div>
        <?php endif; ?>

    <div class="card shadow-sm">

        <div class="card-header">
            <i class="fas fa-user-edit me-2"></i>
            Informations de l'enseignant
        </div>

        <div class="card-body">

            <form action="../traitements/traiter_modification_enseignant.php" method="POST">
                <input type="hidden" name="id_enseignant" value="<?= $id; ?>">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label for="nomEnseignant" class="form-label">
                            Nom
                        </label>

                        <input
                            id="nomEnseignant"
                            type="text"
                            class="form-control"
                            name="nom_enseignant"
                            value="<?= htmlspecialchars($ancien_formulaire['nom_enseignant'] ?? $enseignant['nom_enseignant']); ?>"
                            required
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="prenomEnseignant" class="form-label">
                            Prénom
                        </label>

                        <input
                            id="prenomEnseignant"
                            type="text"
                            class="form-control"
                            name="prenom_enseignant"
                            value="<?= htmlspecialchars($ancien_formulaire['prenom_enseignant'] ?? $enseignant['prenom_enseignant']); ?>"
                            required
                        >
                    </div>

                </div>

                <div class="row">

                <div class="col-md-6 mb-3">
                    <label for="dateNaissance" class="form-label">
                        Date de naissance
                    </label>

                    <input
                        id="dateNaissance"
                        type="date"
                        class="form-control"
                        name="date_naissance"
                        value="<?= htmlspecialchars($ancien_formulaire['date_naissance'] ?? $enseignant['date_naissance']); ?>"
                        required
                    >
                </div>

                <div class="col-md-6 mb-3">
                    <label for="lieuNaissance" class="form-label">
                        Lieu de naissance
                    </label>

                    <input
                        id="lieuNaissance"
                        type="text"
                        class="form-control"
                        name="lieu_naissance"
                        value="<?= htmlspecialchars($ancien_formulaire['lieu_naissance'] ?? $enseignant['lieu_naissance']); ?>"
                        required
                    >
                </div>

            </div>

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label for="grade" class="form-label">
                        Grade
                    </label>

                    <input
                        id="grade"
                        type="text"
                        class="form-control"
                        name="grade"
                        value="<?= htmlspecialchars($ancien_formulaire['grade'] ?? $enseignant['grade']); ?>"
                        required
                    >
                </div>

                <div class="col-md-6 mb-3">
                    <label for="telephone" class="form-label">
                        Téléphone
                    </label>

                    <input
                        id="telephone"
                        type="tel"
                        class="form-control"
                        name="telephone"
                        value="<?= htmlspecialchars($ancien_formulaire['telephone'] ?? $enseignant['telephone']); ?>"
                        required
                    >
                </div>

            </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label for="matricule" class="form-label">
                            Matricule
                        </label>

                        <input
                            id="matricule"
                            type="text"
                            class="form-control"
                            name="matricule"
                            value="<?= htmlspecialchars($ancien_formulaire['matricule'] ?? $enseignant['matricule']); ?>"
                            required
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">
                            Adresse email
                        </label>

                        <input
                            id="email"
                            type="email"
                            class="form-control"
                            name="email"
                            value="<?= htmlspecialchars($ancien_formulaire['email'] ?? $enseignant['email']); ?>"
                            required
                        >
                    </div>

                </div>


                <hr>

                <div class="d-flex justify-content-end">

                    <a
                        href="/Gestion_Ecole_Primaire/enseignants/liste.php"
                        class="btn btn-secondary me-2"
                    >
                        <i class="fas fa-arrow-left me-1"></i>
                        Annuler
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                        name="modifier_enseignant"
                    >
                        <i class="fas fa-save me-1"></i>
                        Enregistrer les modifications
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

<?php
    include_once('../includes/footer.php');
?>