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
        <?= htmlspecialchars($message ?? '', ENT_QUOTES, 'UTF-8'); ?>
    </div>
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

                    <!-- Prénom -->
                    <div class="col-md-6 mb-3">

                        <label
                            for="prenomEnseignant"
                            class="form-label"
                        >
                            Prénom
                        </label>

                        <input
                            value="<?= htmlspecialchars($ancien_formulaire['prenom_enseignant'] ?? ''); ?>"
                            id="prenomEnseignant"
                            type="text"
                            class="form-control"
                            name="prenom_enseignant"
                            placeholder="Prénom de l'enseignant"
                            required
                        >

                    </div>

                    <!-- Nom -->
                    <div class="col-md-6 mb-3">

                        <label
                            for="nomEnseignant"
                            class="form-label"
                        >
                            Nom
                        </label>

                        <input
                            value="<?= htmlspecialchars($ancien_formulaire['nom_enseignant'] ?? ''); ?>"
                            id="nomEnseignant"
                            type="text"
                            class="form-control"
                            name="nom_enseignant"
                            placeholder="Nom de l'enseignant"
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
                            value="<?= htmlspecialchars($ancien_formulaire['matricule'] ?? ''); ?>"
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
                            value="<?= htmlspecialchars($ancien_formulaire['email'] ?? ''); ?>"
                            id="email"
                            type="email"
                            class="form-control"
                            name="email"
                            placeholder="exemple@email.com"
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
                            value="<?= htmlspecialchars($ancien_formulaire['date_naissance'] ?? ''); ?>"
                            id="dateNaissance"
                            type="date"
                            class="form-control"
                            name="date_naissance"
                            required
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="lieuNaissance" class="form-label">
                            Lieu de naissance
                        </label>

                        <input
                            value="<?= htmlspecialchars($ancien_formulaire['lieu_naissance'] ?? ''); ?>"
                            id="lieuNaissance"
                            type="text"
                            class="form-control"
                            name="lieu_naissance"
                            placeholder="Ex : Dakar"
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
                            value="<?= htmlspecialchars($ancien_formulaire['grade'] ?? ''); ?>"
                            id="grade"
                            type="text"
                            class="form-control"
                            name="grade"
                            placeholder="Ex : IP/3"
                            required
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="telephone" class="form-label">
                            Téléphone
                        </label>

                        <input
                            value="<?= htmlspecialchars($ancien_formulaire['telephone'] ?? ''); ?>"
                            id="telephone"
                            type="tel"
                            class="form-control"
                            name="telephone"
                            placeholder="Ex : 77 123 45 67"
                            required
                        >
                    </div>

                </div>

                
            <div class="row">

                <!-- Fonction -->
                <div class="col-md-6 mb-3">
                    <label for="fonction" class="form-label">
                        Fonction
                    </label>

                    <select
                        id="fonction"
                        class="form-select"
                        name="fonction"
                    >
                        <option value="">Non renseignée</option>

                        <option
                            value="adjoint"
                            <?= htmlspecialchars(($ancien_formulaire['fonction'] ?? '') === 'adjoint' ? 'selected' : ''); ?>
                        >
                            Adjoint
                        </option>

                        <option
                            value="direction"
                            <?= htmlspecialchars(($ancien_formulaire['fonction'] ?? '') === 'direction' ? 'selected' : ''); ?>
                        >
                            Direction
                        </option>
                    </select>
                </div>

                <!-- Statut -->
                    <div class="col-md-6 mb-3">
                        <label for="statut" class="form-label">
                            Statut
                        </label>

                        <select
                            id="statut"
                            class="form-select"
                            name="statut"
                        >
                            <option value="">Non renseigné</option>

                            <option
                                value="actif"
                                <?= htmlspecialchars(($ancien_formulaire['statut'] ?? '') === 'actif' ? 'selected' : ''); ?>
                            >
                                Actif
                            </option>

                            <option
                                value="inactif"
                                <?= htmlspecialchars(($ancien_formulaire['statut'] ?? '') === 'inactif' ? 'selected' : ''); ?>
                            >
                                Inactif
                            </option>
                        </select>
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