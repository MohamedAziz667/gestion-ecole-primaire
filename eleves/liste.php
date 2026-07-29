<?php
    include_once('../includes/auth_check.php');
?>
    <div class="container-fluid px-4">

        <!-- Titre -->
        <h1 class="mt-4">
            Liste des Élèves
        </h1>

        <!-- Breadcrumb -->
        <ol class="breadcrumb mb-4">

            <li class="breadcrumb-item">
                <a href="../index.php">
                    Dashboard
                </a>
            </li>

            <li class="breadcrumb-item active">
                Liste des élèves
            </li>

        </ol>

        <!-- Bouton ajout -->
        <div class="mb-3">

            <a href="ajouter.php"
               class="btn btn-primary">

                <i class="fas fa-user-plus me-1"></i>

                Ajouter un élève

            </a>

        </div>

        <!-- Tableau -->
        <div class="card mb-4">

            <div class="card-header">

                <i class="fas fa-table me-1"></i>

                Liste complète des élèves

            </div>

            <div class="card-body">

                <table id="datatablesSimple"
                       class="table table-bordered table-striped">

                    <thead class="table-dark">

                        <tr>

                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Sexe</th>
                            <th>Adresse</th>
                            <th>Date naissance</th>
                            <th>Classe</th>
                            <th>Année scolaire</th>
                            <th>Statut</th>
                            <th>Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                        <!-- Exemple ligne statique -->

                        <tr>

                            <td>1</td>
                            <td>Diallo</td>
                            <td>Mamadou</td>
                            <td>Masculin</td>
                            <td>Dakar</td>
                            <td>12/03/2015</td>
                            <td>CM1</td>
                            <td>2025-2026</td>
                            <td>

                                <span class="badge bg-success">
                                    Admis
                                </span>

                            </td>

                            <td>

                                <a href="modifier.php"
                                   class="btn btn-warning btn-sm">

                                    Modifier

                                </a>

                                <a href="#"
                                   class="btn btn-danger btn-sm">

                                    Supprimer

                                </a>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>
