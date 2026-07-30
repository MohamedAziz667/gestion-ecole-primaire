<?php
    include_once('../includes/auth_check.php');
    include_once('../includes/header.php');
    include_once('../includes/navbar.php');
    include_once('../includes/sidebar.php');
?>

<div class="container-fluid px-4">

    <h1 class="mt-4">Détails de la classe</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/index.php">
                Tableau de bord
            </a>
        </li>

        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/classes/liste.php">
                Classes
            </a>
        </li>

        <li class="breadcrumb-item active">
            Détail
        </li>
    </ol>


    <!-- Informations principales de la classe -->
    <div class="card mb-4 shadow-sm">

        <div class="card-header">
            <i class="fas fa-school me-2"></i>
            Informations de la classe
        </div>


        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-md-6">

                    <h5 class="text-muted">
                        Classe
                    </h5>

                    <h2 class="text-primary">
                        CM1
                    </h2>

                </div>


                <div class="col-md-6">

                    <h5 class="text-muted">
                        Enseignant titulaire
                    </h5>

                    <h4>
                        Mamadou Diallo
                    </h4>

                </div>

            </div>

        </div>

    </div>



    <!-- Statistiques -->
    <div class="row mb-4">


        <div class="col-xl-4 col-md-6">

            <div class="card bg-primary text-white mb-4">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>
                            <h6>
                                Nombre d'élèves
                            </h6>

                            <h2>
                                28
                            </h2>
                        </div>


                        <div class="fs-1">

                            <i class="fas fa-users"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <div class="col-xl-4 col-md-6">

            <div class="card bg-success text-white mb-4">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h6>
                                Garçons
                            </h6>

                            <h2>
                                15
                            </h2>

                        </div>


                        <div class="fs-1">

                            <i class="fas fa-male"></i>

                        </div>


                    </div>

                </div>

            </div>

        </div>



        <div class="col-xl-4 col-md-6">

            <div class="card bg-warning text-dark mb-4">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h6>
                                Filles
                            </h6>

                            <h2>
                                13
                            </h2>

                        </div>


                        <div class="fs-1">

                            <i class="fas fa-female"></i>

                        </div>


                    </div>

                </div>

            </div>

        </div>


    </div>




    <!-- Actions -->
    <div class="d-flex justify-content-between align-items-center mb-3">


        <h4>
            Liste des élèves
        </h4>



        <div>


            <a
                href="/Gestion_Ecole_Primaire/inscriptions/ajouter.php?id_classe=3"
                class="btn btn-success me-2"
            >

                <i class="fas fa-user-plus me-1"></i>

                Inscrire un élève

            </a>



            <a
                href="/Gestion_Ecole_Primaire/evaluations/liste.php"
                class="btn btn-primary"
            >

                <i class="fas fa-chart-line me-1"></i>

                Voir les évaluations

            </a>


        </div>


    </div>





    <!-- Tableau des élèves -->

    <div class="card shadow-sm">


        <div class="card-header">

            <i class="fas fa-users me-2"></i>

            Élèves de la classe CM1

        </div>



        <div class="card-body">


            <div class="table-responsive">


                <table class="table table-bordered table-hover align-middle">


                    <thead class="table-light">


                        <tr>

                            <th>#</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Sexe</th>
                            <th>Date naissance</th>
                            <th class="text-center">
                                Actions
                            </th>

                        </tr>


                    </thead>




                    <tbody>


                        <tr>

                            <td>
                                1
                            </td>

                            <td>
                                Diallo
                            </td>

                            <td>
                                Moussa
                            </td>

                            <td>
                                M
                            </td>

                            <td>
                                12/03/2016
                            </td>


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

                            <td>
                                2
                            </td>

                            <td>
                                Sow
                            </td>

                            <td>
                                Aminata
                            </td>

                            <td>
                                F
                            </td>

                            <td>
                                08/09/2015
                            </td>


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


                    </tbody>


                </table>


            </div>


        </div>


    </div>


</div>