<?php
    include_once('../includes/auth_check.php');
    include_once('../includes/header.php');
    include_once('../includes/navbar.php');
    include_once('../includes/sidebar.php');
?>

<div class="container-fluid px-4">

    <h1 class="mt-4">Gestion des utilisateurs</h1>


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
            Utilisateurs
        </li>

    </ol>






    <div class="row">


        <!-- Formulaire ajout utilisateur -->

        <div class="col-lg-5">


            <div class="card shadow-sm mb-4">


                <div class="card-header">

                    <i class="fas fa-user-plus me-2"></i>

                    Ajouter un utilisateur

                </div>





                <div class="card-body">


                    <form action="#" method="post">


                        <div class="mb-3">


                            <label class="form-label">

                                Rôle utilisateur

                            </label>


                            <select class="form-select" required>


                                <option selected disabled>
                                    -- Choisir un rôle --
                                </option>


                                <option>
                                    Directeur
                                </option>


                                <option>
                                    Enseignant
                                </option>


                            </select>


                        </div>






                        <div class="mb-3">


                            <label class="form-label">

                                Enseignant associé

                            </label>


                            <select class="form-select">


                                <option selected>

                                    Aucun (Directeur)

                                </option>


                                <option>

                                    Diallo Mamadou

                                </option>


                                <option>

                                    Ndiaye Awa

                                </option>


                                <option>

                                    Sow Fatou

                                </option>


                            </select>


                            <div class="form-text">

                                Obligatoire uniquement pour un compte enseignant.

                            </div>


                        </div>






                        <div class="mb-3">


                            <label class="form-label">

                                Mot de passe

                            </label>


                            <input

                                type="password"

                                class="form-control"

                                placeholder="Mot de passe"

                                required

                            >


                        </div>






                        <div class="mb-3">


                            <label class="form-label">

                                Confirmation du mot de passe

                            </label>


                            <input

                                type="password"

                                class="form-control"

                                placeholder="Confirmer le mot de passe"

                                required

                            >


                        </div>






                        <div class="d-grid">


                            <button

                                type="submit"

                                class="btn btn-primary"

                            >


                                <i class="fas fa-save me-1"></i>

                                Créer le compte


                            </button>


                        </div>



                    </form>


                </div>


            </div>


        </div>









        <!-- Liste utilisateurs -->

        <div class="col-lg-7">


            <div class="card shadow-sm">


                <div class="card-header">


                    <i class="fas fa-users-cog me-2"></i>

                    Liste des utilisateurs


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
                                        Utilisateur
                                    </th>


                                    <th>
                                        Rôle
                                    </th>


                                    <th>
                                        Enseignant associé
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
                                        Admin
                                    </td>


                                    <td>

                                        <span class="badge bg-danger">

                                            Directeur

                                        </span>

                                    </td>


                                    <td>
                                        Aucun
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
                                        Enseignant_CM1
                                    </td>


                                    <td>

                                        <span class="badge bg-primary">

                                            Enseignant

                                        </span>

                                    </td>


                                    <td>
                                        Diallo Mamadou
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