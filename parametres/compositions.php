<?php
    include_once('../includes/auth_check.php');
    include_once('../includes/header.php');
    include_once('../includes/navbar.php');
    include_once('../includes/sidebar.php');
?>

<div class="container-fluid px-4">

    <h1 class="mt-4">Gestion des compositions</h1>


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
            Compositions
        </li>

    </ol>





    <div class="row">



        <!-- Formulaire d'ajout -->

        <div class="col-lg-5">


            <div class="card shadow-sm mb-4">


                <div class="card-header">

                    <i class="fas fa-file-signature me-2"></i>

                    Nouvelle composition

                </div>




                <div class="card-body">


                    <form action="#" method="post">


                        <div class="mb-3">


                            <label class="form-label">

                                Numéro de composition

                            </label>


                            <select class="form-select" required>


                                <option selected disabled>
                                    -- Choisir un numéro --
                                </option>


                                <option>
                                    Composition 1
                                </option>


                                <option>
                                    Composition 2
                                </option>


                                <option>
                                    Composition 3
                                </option>


                            </select>


                        </div>





                        <div class="mb-3">


                            <label class="form-label">

                                Date de composition

                            </label>


                            <input

                                type="date"

                                class="form-control"

                                required

                            >


                        </div>





                        <div class="mb-3">


                            <label class="form-label">

                                Trimestre

                            </label>


                            <select class="form-select" required>


                                <option selected disabled>
                                    -- Sélectionner un trimestre --
                                </option>


                                <option>
                                    Premier trimestre
                                </option>


                                <option>
                                    Deuxième trimestre
                                </option>


                                <option>
                                    Troisième trimestre
                                </option>


                            </select>


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







        <!-- Liste des compositions -->

        <div class="col-lg-7">


            <div class="card shadow-sm">


                <div class="card-header">


                    <i class="fas fa-list-alt me-2"></i>

                    Liste des compositions


                </div>





                <div class="card-body">


                    <div class="table-responsive">


                        <table class="table table-bordered table-hover align-middle">


                            <thead class="table-light">


                                <tr>


                                    <th>
                                        #
                                    </th>


                                    <th>
                                        Numéro
                                    </th>


                                    <th>
                                        Date
                                    </th>


                                    <th>
                                        Trimestre
                                    </th>


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
                                        Composition 1
                                    </td>


                                    <td>
                                        15/12/2025
                                    </td>


                                    <td>
                                        Premier trimestre
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
                                        Composition 2
                                    </td>


                                    <td>
                                        20/03/2026
                                    </td>


                                    <td>
                                        Deuxième trimestre
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
                                        3
                                    </td>


                                    <td>
                                        Composition 3
                                    </td>


                                    <td>
                                        05/06/2026
                                    </td>


                                    <td>
                                        Troisième trimestre
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


    </div>



</div>

<?php 
    include_once('../includes/footer.php');
?>