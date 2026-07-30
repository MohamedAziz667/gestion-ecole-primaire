<?php
    include_once('../includes/auth_check.php');
    include_once('../includes/header.php');
    include_once('../includes/navbar.php');
    include_once('../includes/sidebar.php');
?>

<div class="container-fluid px-4">

    <h1 class="mt-4">Nouvelle inscription</h1>

    <ol class="breadcrumb mb-4">

        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/index.php">
                Tableau de bord
            </a>
        </li>

        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/inscriptions/liste.php">
                Inscriptions
            </a>
        </li>

        <li class="breadcrumb-item active">
            Ajouter
        </li>

    </ol>



    <div class="card shadow-sm">


        <div class="card-header">

            <i class="fas fa-user-plus me-2"></i>

            Formulaire d'inscription

        </div>





        <div class="card-body">


            <form action="#" method="post">



                <!-- Élève -->

                <div class="mb-3">


                    <label class="form-label">
                        Élève
                    </label>


                    <select class="form-select" required>


                        <option selected disabled>
                            -- Sélectionner un élève --
                        </option>


                        <option>
                            Diallo Moussa
                        </option>


                        <option>
                            Sow Aminata
                        </option>


                        <option>
                            Ndiaye Fatou
                        </option>


                    </select>


                </div>






                <div class="row">


                    <!-- Classe -->

                    <div class="col-md-6 mb-3">


                        <label class="form-label">
                            Classe
                        </label>


                        <select class="form-select" required>


                            <option selected disabled>
                                -- Sélectionner une classe --
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





                    <!-- Année scolaire -->

                    <div class="col-md-6 mb-3">


                        <label class="form-label">
                            Année scolaire
                        </label>


                        <select class="form-select" required>


                            <option selected disabled>
                                -- Sélectionner une année --
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






                <!-- Statut -->

                <div class="mb-3">


                    <label class="form-label">
                        Statut
                    </label>


                    <select class="form-select">


                        <option>
                            Inscrit
                        </option>


                        <option>
                            Admis
                        </option>


                        <option>
                            Ajourné
                        </option>


                    </select>


                </div>






                <hr>



                <div class="d-flex justify-content-end">



                    <a
                        href="/Gestion_Ecole_Primaire/inscriptions/liste.php"
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
<?php include_once('../includes/footer.php'); ?>