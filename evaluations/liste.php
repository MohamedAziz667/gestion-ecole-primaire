<?php
    include_once('../includes/auth_check.php');
    include_once('../includes/header.php');
    include_once('../includes/navbar.php');
    include_once('../includes/sidebar.php');
?>

<div class="container-fluid px-4">

    <h1 class="mt-4">Gestion des évaluations</h1>


    <ol class="breadcrumb mb-4">

        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/index.php">
                Tableau de bord
            </a>
        </li>

        <li class="breadcrumb-item active">
            Évaluations
        </li>

    </ol>




    <div class="card mb-4">


        <div class="card-header d-flex justify-content-between align-items-center">


            <div>

                <i class="fas fa-file-alt me-2"></i>

                Notes des élèves

            </div>




            <a
                href="/Gestion_Ecole_Primaire/evaluations/ajouter.php"
                class="btn btn-primary"
            >

                <i class="fas fa-plus me-1"></i>

                Ajouter des notes

            </a>


        </div>






        <div class="card-body">



            <!-- Filtres -->

            <div class="row mb-4">


                <div class="col-md-3">


                    <label class="form-label">
                        Classe
                    </label>


                    <select class="form-select">

                        <option>
                            CM1
                        </option>

                        <option>
                            CM2
                        </option>

                        <option>
                            CE2
                        </option>


                    </select>


                </div>





                <div class="col-md-3">


                    <label class="form-label">
                        Composition
                    </label>


                    <select class="form-select">

                        <option>
                            Composition 1
                        </option>

                        <option>
                            Composition 2
                        </option>

                        <option>
                            Examen final
                        </option>


                    </select>


                </div>





                <div class="col-md-3">


                    <label class="form-label">
                        Matière
                    </label>


                    <select class="form-select">

                        <option>
                            Mathématiques
                        </option>

                        <option>
                            Français
                        </option>

                        <option>
                            Sciences
                        </option>


                    </select>


                </div>





                <div class="col-md-3 d-flex align-items-end">


                    <button class="btn btn-secondary w-100">

                        <i class="fas fa-search me-1"></i>

                        Afficher

                    </button>


                </div>



            </div>









            <!-- Tableau des notes -->

            <div class="table-responsive">


                <table class="table table-bordered table-hover align-middle">


                    <thead class="table-light">


                        <tr>


                            <th>
                                Élève
                            </th>


                            <th>
                                Français
                            </th>


                            <th>
                                Mathématiques
                            </th>


                            <th>
                                Sciences
                            </th>


                            <th>
                                Moyenne
                            </th>


                            <th class="text-center">
                                Actions
                            </th>


                        </tr>


                    </thead>







                    <tbody>



                        <tr>


                            <td>
                                Diallo Moussa
                            </td>


                            <td>
                                15
                            </td>


                            <td>
                                14
                            </td>


                            <td>
                                16
                            </td>


                            <td>


                                <span class="badge bg-success">

                                    15

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
                                Sow Aminata
                            </td>


                            <td>
                                12
                            </td>


                            <td>
                                13
                            </td>


                            <td>
                                11
                            </td>


                            <td>


                                <span class="badge bg-warning text-dark">

                                    12

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