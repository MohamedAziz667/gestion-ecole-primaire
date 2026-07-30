<?php
    include_once('../includes/auth_check.php');
    include_once('../includes/header.php');
    include_once('../includes/navbar.php');
    include_once('../includes/sidebar.php');
?>

<div class="container-fluid px-4">

    <h1 class="mt-4">Gestion des classes</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/index.php">Tableau de bord</a>
        </li>
        <li class="breadcrumb-item active">Classes</li>
    </ol>

    <div class="card mb-4">

        <div class="card-header d-flex justify-content-between align-items-center">

            <div>
                <i class="fas fa-school me-2"></i>
                Liste des classes
            </div>

            <a href="/Gestion_Ecole_Primaire/classes/ajouter.php"
               class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Ajouter une classe
            </a>

        </div>

        <div class="card-body">

            <div class="row mb-3">

                <div class="col-md-4">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Rechercher une classe..."
                    >
                </div>

            </div>

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>Nom de la classe</th>
                            <th>Enseignant</th>
                            <th class="text-center">Nombre d'élèves</th>
                            <th class="text-center">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td>CI</td>

                            <td>
                                Mamadou Diallo
                            </td>

                            <td class="text-center">
                                28
                            </td>

                            <td class="text-center">

                                <a
                                    href="/Gestion_Ecole_Primaire/classes/detail.php"
                                    class="btn btn-info btn-sm"
                                >
                                    <i class="fas fa-eye"></i>
                                    Voir
                                </a>

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

                            <td>CP</td>

                            <td>
                                Awa Ndiaye
                            </td>

                            <td class="text-center">
                                31
                            </td>

                            <td class="text-center">

                                <a
                                    href="/Gestion_Ecole_Primaire/classes/detail.php"
                                    class="btn btn-info btn-sm"
                                >
                                    <i class="fas fa-eye"></i>
                                    Voir
                                </a>

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

                            <td>CE1</td>

                            <td>
                                Fatou Sow
                            </td>

                            <td class="text-center">
                                26
                            </td>

                            <td class="text-center">

                                <a
                                    href="/Gestion_Ecole_Primaire/classes/detail.php"
                                    class="btn btn-info btn-sm"
                                >
                                    <i class="fas fa-eye"></i>
                                    Voir
                                </a>

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

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>