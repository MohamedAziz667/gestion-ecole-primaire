<?php
    include_once('../includes/auth_check.php');
    include_once('../includes/header.php');
    include_once('../includes/navbar.php');
    include_once('../includes/sidebar.php');
?>
    <div class="container-fluid px-4">

    <h1 class="mt-4">Gestion des enseignants</h1>

    <ol class="breadcrumb mb-4">

        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/index.php">
                Tableau de bord
            </a>
        </li>

        <li class="breadcrumb-item active">
            Enseignants
        </li>

    </ol>


    <div class="card mb-4">

        <div class="card-header d-flex justify-content-between align-items-center">

            <div>

                <i class="fas fa-chalkboard-teacher me-2"></i>

                Liste des enseignants

            </div>


            <a
                href="/Gestion_Ecole_Primaire/enseignants/ajouter.php"
                class="btn btn-primary"
            >

                <i class="fas fa-plus me-1"></i>

                Ajouter un enseignant

            </a>


        </div>


        <div class="card-body">


            <div class="row mb-3">

                <div class="col-md-4">

                    <input
                        type="text"
                        class="form-control"
                        placeholder="Rechercher un enseignant..."
                    >

                </div>


            </div>



            <div class="table-responsive">


                <table class="table table-bordered table-hover align-middle">


                    <thead class="table-light">


                        <tr>

                            <th>#</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Matricule</th>
                            <th>Email</th>
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
                                Mamadou
                            </td>

                            <td>
                                ENS001
                            </td>

                            <td>
                                mamadou.diallo@email.com
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
                                Ndiaye
                            </td>

                            <td>
                                Awa
                            </td>

                            <td>
                                ENS002
                            </td>

                            <td>
                                awa.ndiaye@email.com
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
<?php 
    include_once('../includes/footer.php');
?>