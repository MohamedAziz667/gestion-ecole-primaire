<?php
    include_once('includes/auth_check.php');
    include_once('includes/header.php');
    include_once('includes/navbar.php');
    include_once('includes/sidebar.php');
?>

    <div class="container-fluid px-4">

    <h1 class="mt-4">
        Tableau de bord
    </h1>


    <ol class="breadcrumb mb-4">

        <li class="breadcrumb-item active">
            Accueil
        </li>

    </ol>





    <!-- Cartes statistiques -->

    <div class="row">



        <div class="col-xl-3 col-md-6">


            <div class="card bg-primary text-white mb-4">


                <div class="card-body">


                    <div class="d-flex justify-content-between align-items-center">


                        <div>

                            <h5>
                                Élèves
                            </h5>

                            <h2>
                                250
                            </h2>

                        </div>


                        <i class="fas fa-user-graduate fa-3x"></i>


                    </div>


                </div>


                <div class="card-footer d-flex align-items-center justify-content-between">


                    <a
                        class="small text-white stretched-link"
                        href="/Gestion_Ecole_Primaire/eleves/liste.php"
                    >

                        Voir les élèves

                    </a>


                    <i class="fas fa-angle-right"></i>


                </div>


            </div>


        </div>







        <div class="col-xl-3 col-md-6">


            <div class="card bg-success text-white mb-4">


                <div class="card-body">


                    <div class="d-flex justify-content-between align-items-center">


                        <div>

                            <h5>
                                Classes
                            </h5>

                            <h2>
                                12
                            </h2>

                        </div>


                        <i class="fas fa-school fa-3x"></i>


                    </div>


                </div>


                <div class="card-footer d-flex align-items-center justify-content-between">


                    <a
                        class="small text-white stretched-link"
                        href="/Gestion_Ecole_Primaire/classes/liste.php"
                    >

                        Voir les classes

                    </a>


                    <i class="fas fa-angle-right"></i>


                </div>


            </div>


        </div>







        <div class="col-xl-3 col-md-6">


            <div class="card bg-warning text-dark mb-4">


                <div class="card-body">


                    <div class="d-flex justify-content-between align-items-center">


                        <div>

                            <h5>
                                Enseignants
                            </h5>

                            <h2>
                                18
                            </h2>

                        </div>


                        <i class="fas fa-chalkboard-teacher fa-3x"></i>


                    </div>


                </div>


                <div class="card-footer d-flex align-items-center justify-content-between">


                    <a
                        class="small text-dark stretched-link"
                        href="/Gestion_Ecole_Primaire/enseignants/liste.php"
                    >

                        Voir les enseignants

                    </a>


                    <i class="fas fa-angle-right"></i>


                </div>


            </div>


        </div>







        <div class="col-xl-3 col-md-6">


            <div class="card bg-danger text-white mb-4">


                <div class="card-body">


                    <div class="d-flex justify-content-between align-items-center">


                        <div>

                            <h5>
                                Inscriptions
                            </h5>

                            <h2>
                                230
                            </h2>

                        </div>


                        <i class="fas fa-file-signature fa-3x"></i>


                    </div>


                </div>


                <div class="card-footer d-flex align-items-center justify-content-between">


                    <a
                        class="small text-white stretched-link"
                        href="/Gestion_Ecole_Primaire/inscriptions/liste.php"
                    >

                        Voir les inscriptions

                    </a>


                    <i class="fas fa-angle-right"></i>


                </div>


            </div>


        </div>


    </div>







    <!-- Graphique + dernières informations -->

    <div class="row">


        <div class="col-xl-8">


            <div class="card mb-4">


                <div class="card-header">

                    <i class="fas fa-chart-bar me-1"></i>

                    Effectifs par classe

                </div>


                <div class="card-body">


                    <div
                        style="height:300px;"
                        class="d-flex justify-content-center align-items-center"
                    >

                        <span class="text-muted">

                            Zone réservée au graphique des effectifs

                        </span>


                    </div>


                </div>


            </div>


        </div>







        <div class="col-xl-4">


            <div class="card mb-4">


                <div class="card-header">

                    <i class="fas fa-calendar me-1"></i>

                    Année scolaire active

                </div>


                <div class="card-body text-center">


                    <h3>

                        2026 - 2027

                    </h3>


                    <p class="text-muted">

                        Année scolaire en cours

                    </p>


                </div>


            </div>


        </div>



    </div>







    <!-- Accès rapides -->


    <div class="card mb-4">


        <div class="card-header">


            <i class="fas fa-bolt me-1"></i>

            Accès rapides


        </div>



        <div class="card-body">


            <div class="row text-center">



                <div class="col-md-3 mb-3">


                    <a
                        href="/Gestion_Ecole_Primaire/inscriptions/ajouter.php"
                        class="btn btn-primary w-100"
                    >

                        <i class="fas fa-user-plus me-1"></i>

                        Nouvelle inscription

                    </a>


                </div>





                <div class="col-md-3 mb-3">


                    <a
                        href="/Gestion_Ecole_Primaire/classes/ajouter.php"
                        class="btn btn-success w-100"
                    >

                        <i class="fas fa-school me-1"></i>

                        Nouvelle classe

                    </a>


                </div>





                <div class="col-md-3 mb-3">


                    <a
                        href="/Gestion_Ecole_Primaire/evaluations/ajouter.php"
                        class="btn btn-warning w-100"
                    >

                        <i class="fas fa-edit me-1"></i>

                        Saisir notes

                    </a>


                </div>





                <div class="col-md-3 mb-3">


                    <a
                        href="/Gestion_Ecole_Primaire/enseignants/ajouter.php"
                        class="btn btn-danger w-100"
                    >

                        <i class="fas fa-user-tie me-1"></i>

                        Ajouter enseignant

                    </a>


                </div>


            </div>


        </div>


    </div>



</div>

<?php
    include_once('includes/footer.php');
?>