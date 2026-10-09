<?php
    include_once('../includes/auth_check.php');
    include_once('../includes/header.php');
    include_once('../includes/navbar.php');
    include_once('../includes/sidebar.php');

    $message = $_SESSION['message'] ?? null;
    unset($_SESSION['message']);
    $ancien_formulaire = $_SESSION['ancien_formulaire'] ?? [];
    unset($_SESSION['ancien_formulaire']);

    $type_message = $_SESSION['type_message'] ?? 'info';
    unset($_SESSION['type_message']);
?>

<div class="container-fluid px-4">

    <h1 class="mt-4">Ajouter un enseignant</h1>

    <ol class="breadcrumb mb-4">

        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/index.php">
                Tableau de bord
            </a>
        </li>

        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/enseignants/liste.php">
                Enseignants
            </a>
        </li>

        <li class="breadcrumb-item active">
            Ajouter
        </li>

    </ol>
    <?php if($message): ?>
        <div class="alert alert-<?= $type_message; ?>"> 
        <?= $message; ?></div>
    <?php endif; ?>
    <div class="card shadow-sm">

        <div class="card-header">

            <i class="fas fa-user-plus me-2"></i>

            Nouvel enseignant

        </div>

        <div class="card-body">

            <form
                action="../traitements/traiter_ajout_enseignant.php"
                method="POST"
            >

                <div class="row">

                    <!-- Nom -->
                    <div class="col-md-6 mb-3">

                        <label
                            for="nomEnseignant"
                            class="form-label"
                        >
                            Nom
                        </label>

                        <input
                                value="<?= $ancien_formulaire['nom_enseignant'] ?? ''; ?>"
                            id="nomEnseignant"
                            type="text"
                            class="form-control"
                            name="nom_enseignant"
                            placeholder="Nom de l'enseignant"
                            required
                        >

                    </div>

                    <!-- Prénom -->
                    <div class="col-md-6 mb-3">

                        <label
                            for="prenomEnseignant"
                            class="form-label"
                        >
                            Prénom
                        </label>

                        <input
                            value="<?= $ancien_formulaire['prenom_enseignant'] ?? ''; ?>"
                            id="prenomEnseignant"
                            type="text"
                            class="form-control"
                            name="prenom_enseignant"
                            placeholder="Prénom de l'enseignant"
                            required
                        >

                    </div>

                </div>

                <div class="row">

                    <!-- Matricule -->
                    <div class="col-md-6 mb-3">

                        <label
                            for="matricule"
                            class="form-label"
                        >
                            Matricule
                        </label>

                        <input
                            value="<?= $ancien_formulaire['matricule'] ?? ''; ?>"
                            id="matricule"
                            type="text"
                            class="form-control"
                            name="matricule"
                            placeholder="Ex : ENS001"
                            required
                        >

                    </div>

                    <!-- Email -->
                    <div class="col-md-6 mb-3">

                        <label
                            for="email"
                            class="form-label"
                        >
                            Adresse email
                        </label>

                        <input
                            value="<?= $ancien_formulaire['email'] ?? ''; ?>"
                            id="email"
                            type="email"
                            class="form-control"
                            name="email"
                            placeholder="exemple@email.com"
                            required
                        >

                    </div>

                                    <div class="row">

                    <div class="col-md-6 mb-3">
                        <label for="dateNaissance" class="form-label">
                            Date de naissance
                        </label>

                        <input
                            value="<?= $ancien_formulaire['date_naissance'] ?? ''; ?>"
                            id="dateNaissance"
                            type="date"
                            class="form-control"
                            name="date_naissance"
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="lieuNaissance" class="form-label">
                            Lieu de naissance
                        </label>

                        <input
                            value="<?= $ancien_formulaire['lieu_naissance'] ?? ''; ?>"
                            id="lieuNaissance"
                            type="text"
                            class="form-control"
                            name="lieu_naissance"
                            placeholder="Ex : Dakar"
                        >
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label for="grade" class="form-label">
                            Grade
                        </label>

                        <input
                            value="<?= $ancien_formulaire['grade'] ?? ''; ?>"
                            id="grade"
                            type="text"
                            class="form-control"
                            name="grade"
                            placeholder="Ex : IP/3"
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="telephone" class="form-label">
                            Téléphone
                        </label>

                        <input
                            value="<?= $ancien_formulaire['telephone'] ?? ''; ?>"
                            id="telephone"
                            type="tel"
                            class="form-control"
                            name="telephone"
                            placeholder="Ex : 77 123 45 67"
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
                        Retour
                    </a>

                    <button
                        type="reset"
                        class="btn btn-warning me-2"
                    >
                        <i class="fas fa-rotate-left me-1"></i>
                        Réinitialiser
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                        name="enregistrer_enseignant"
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