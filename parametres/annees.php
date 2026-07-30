<?php
    include_once('../includes/auth_check.php');
    include_once('../includes/header.php');
    include_once('../includes/navbar.php');
    include_once('../includes/sidebar.php');
?>



<div class="container-fluid px-4">

    <h1 class="mt-4">Gestion des années scolaires</h1>

    <ol class="breadcrumb mb-4">

        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/index.php">
                Tableau de bord
            </a>
        </li>

        <li class="breadcrumb-item">
            Paramètres
        </li>

        <li class="breadcrumb-item active">
            Années scolaires
        </li>

    </ol>



    <div class="row">

        <!-- Formulaire -->

        <div class="col-lg-4">

            <div class="card shadow-sm mb-4">

                <div class="card-header">

                    <i class="fas fa-calendar-alt me-2"></i>

                    Nouvelle année scolaire

                </div>

                <div class="card-body">

                    <form action="#" method="post">

                        <div class="mb-3">

                            <label class="form-label">

                                Année scolaire

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                placeholder="Ex : 2026-2027"
                            >

                        </div>

                        <div class="d-grid">

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



        <!-- Liste -->

        <div class="col-lg-8">

            <div class="card shadow-sm">

                <div class="card-header">

                    <i class="fas fa-list me-2"></i>

                    Liste des années scolaires

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover align-middle">

                            <thead class="table-light">

                                <tr>

                                    <th>#</th>

                                    <th>Année scolaire</th>

                                    <th class="text-center">
                                        Actions
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <tr>

                                    <td>1</td>

                                    <td>2024-2025</td>

                                    <td class="text-center">

                                        <a
                                            href="#"
                                            class="btn btn-warning btn-sm"
                                        >
                                            <i class="fas fa-edit"></i>
                                            Modifier
                                        </a>

                                        <a
                                            href="#"
                                            class="btn btn-danger btn-sm"
                                        >
                                            <i class="fas fa-trash"></i>
                                            Supprimer
                                        </a>

                                    </td>

                                </tr>

                                <tr>

                                    <td>2</td>

                                    <td>2025-2026</td>

                                    <td class="text-center">

                                        <a
                                            href="#"
                                            class="btn btn-warning btn-sm"
                                        >
                                            <i class="fas fa-edit"></i>
                                            Modifier
                                        </a>

                                        <a
                                            href="#"
                                            class="btn btn-danger btn-sm"
                                        >
                                            <i class="fas fa-trash"></i>
                                            Supprimer
                                        </a>

                                    </td>

                                </tr>

                                <tr>

                                    <td>3</td>

                                    <td>2026-2027</td>

                                    <td class="text-center">

                                        <a
                                            href="#"
                                            class="btn btn-warning btn-sm"
                                        >
                                            <i class="fas fa-edit"></i>
                                            Modifier
                                        </a>

                                        <a
                                            href="#"
                                            class="btn btn-danger btn-sm"
                                        >
                                            Supprimer
                                        </a>

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
<?php include_once('../includes/footer.php'); ?>