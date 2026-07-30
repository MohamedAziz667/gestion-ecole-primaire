<?php
    include_once('../includes/auth_check.php');
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

        <div class="card-body">

            <form action="#" method="post">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Nom de la classe
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            placeholder="Ex : CI, CP, CE1, CE2, CM1 ou CM2"
                            required
                        >

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Enseignant titulaire
                        </label>

                        <select class="form-select" required>

                            <option selected disabled>
                                -- Sélectionner un enseignant --
                            </option>

                            <option>
                                Diallo Mamadou
                            </option>

                            <option>
                                Ndiaye Awa
                            </option>

                            <option>
                                Sow Fatou
                            </option>

                            <option>
                                Ba Moussa
                            </option>

                            <option>
                                Fall Aminata
                            </option>

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
                        type="reset"
                        class="btn btn-warning me-2"
                    >
                        <i class="fas fa-rotate-left me-1"></i>
                        Réinitialiser
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="fas fa-save me-1"></i>
                        Enregistrer
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>