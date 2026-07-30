<?php
    include_once('../includes/auth_check.php');
    include_once('../includes/header.php');
    include_once('../includes/navbar.php');
    include_once('../includes/sidebar.php');
?>
<div class="container-fluid px-4">

    <h1 class="mt-4">Ajouter un enseignant</h1>

    <ol class="breadcrumb mb-4">

        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/index.php">
                Tableau de bord
            </a>
        </li>

        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/enseignants/liste.php">
                Enseignants
            </a>
        </li>

        <li class="breadcrumb-item active">
            Ajouter
        </li>

    </ol>


    <div class="card shadow-sm">


        <div class="card-header">

            <i class="fas fa-user-plus me-2"></i>

            Nouvel enseignant

        </div>



        <div class="card-body">


            <form action="#" method="post">


                <div class="row">


                    <!-- Nom -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Nom
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            placeholder="Nom de l'enseignant"
                            required
                        >

                    </div>



                    <!-- Prénom -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Prénom
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            placeholder="Prénom de l'enseignant"
                            required
                        >

                    </div>


                </div>




                <div class="row">


                    <!-- Matricule -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Matricule
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            placeholder="Ex : ENS001"
                            required
                        >

                    </div>




                    <!-- Email -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Adresse email
                        </label>

                        <input
                            type="email"
                            class="form-control"
                            placeholder="exemple@email.com"
                            required
                        >

                    </div>


                </div>



                <hr>



                <div class="d-flex justify-content-end">


                    <a
                        href="/Gestion_Ecole_Primaire/enseignants/liste.php"
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