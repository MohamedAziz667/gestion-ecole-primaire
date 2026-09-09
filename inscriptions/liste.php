<?php
    include_once('../includes/auth_check.php');
    include_once('../includes/header.php');
    include_once('../includes/navbar.php');
    include_once('../includes/sidebar.php');
?>

<div class="container-fluid px-4">

    <h1 class="mt-4">Gestion des inscriptions</h1>

    <ol class="breadcrumb mb-4">

        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/index.php">
                Tableau de bord
            </a>
        </li>

        <li class="breadcrumb-item active">
            Inscriptions
        </li>

    </ol>



    <div class="card mb-4">


        <div class="card-header d-flex justify-content-between align-items-center">


            <div>

                <i class="fas fa-user-plus me-2"></i>

                Liste des inscriptions

            </div>



            <a
                href="/Gestion_Ecole_Primaire/inscriptions/ajouter.php"
                class="btn btn-primary"
            >

                <i class="fas fa-plus me-1"></i>

                Nouvelle inscription

            </a>


        </div>





        <div class="card-body">



            <!-- Filtres -->

            <div class="row mb-4">


                <div class="col-md-4">

                    <input
                        type="text"
                        class="form-control"
                        placeholder="Rechercher un élève..."
                    >

                </div>



                <div class="col-md-3">

                    <select class="form-select">

                        <option>
                            Toutes les classes
                        </option>

                        <option>
                            CI
                        </option>

                        <option>
                            CP
                        </option>

                        <option>
                            CE1
                        </option>

                        <option>
                            CE2
                        </option>

                        <option>
                            CM1
                        </option>

                        <option>
                            CM2
                        </option>

                    </select>

                </div>



                <div class="col-md-3">

                    <select class="form-select">

                        <option>
                            Année scolaire
                        </option>

                        <option>
                            2025-2026
                        </option>

                        <option>
                            2026-2027
                        </option>

                    </select>

                </div>


            </div>






            <!-- Tableau -->

            <div class="table-responsive">


                <table class="table table-bordered table-hover align-middle">


                    <thead class="table-light">


                        <tr>

                            <th>#</th>
                            <th>Nom élève</th>
                            <th>Prénom</th>
                            <th>Classe</th>
                            <th>Année scolaire</th>
                            <th>Statut</th>
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
                                CM1
                            </td>


                            <td>
                                2025-2026
                            </td>


                            <td>

                                <span class="badge bg-success">

                                    Admis

                                </span>

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
                                CE2
                            </td>


                            <td>
                                2025-2026
                            </td>


                            <td>

                                <span class="badge bg-danger">

                                    Ajourné

                                </span>

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
<?php include_once('../includes/footer.php'); ?>
