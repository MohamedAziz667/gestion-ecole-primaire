<?php
    include_once('../includes/auth_check.php');
    include_once('../includes/header.php');
    include_once('../includes/navbar.php');
    include_once('../includes/sidebar.php');
?>
<div class="container-fluid px-4">

    <h1 class="mt-4">Saisie des évaluations</h1>

    <ol class="breadcrumb mb-4">

        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/index.php">
                Tableau de bord
            </a>
        </li>

        <li class="breadcrumb-item">
            <a href="/Gestion_Ecole_Primaire/evaluations/liste.php">
                Évaluations
            </a>
        </li>

        <li class="breadcrumb-item active">
            Nouvelle évaluation
        </li>

    </ol>



    <!-- Paramètres de l'évaluation -->

    <div class="card mb-4">

        <div class="card-header">

            <i class="fas fa-filter me-2"></i>

            Paramètres de l'évaluation

        </div>

        <div class="card-body">

            <form>

                <div class="row align-items-end">

                    <div class="col-lg-3 col-md-6 mb-3">

                        <label class="form-label">

                            Classe

                        </label>

                        <select class="form-select">

                            <option>Choisir une classe</option>
                            <option>CI</option>
                            <option>CP</option>
                            <option>CE1</option>
                            <option>CE2</option>
                            <option>CM1</option>
                            <option>CM2</option>

                        </select>

                    </div>



                    <div class="col-lg-3 col-md-6 mb-3">

                        <label class="form-label">

                            Composition

                        </label>

                        <select class="form-select">

                            <option>Composition 1</option>
                            <option>Composition 2</option>
                            <option>Composition 3</option>

                        </select>

                    </div>



                    <div class="col-lg-3 col-md-6 mb-3">

                        <label class="form-label">

                            Matière

                        </label>

                        <select class="form-select">

                            <option>Mathématiques</option>
                            <option>Français</option>
                            <option>Sciences</option>

                        </select>

                    </div>



                    <div class="col-lg-3 col-md-6 mb-3 d-grid">

                        <button
                            type="button"
                            class="btn btn-primary"
                        >

                            <i class="fas fa-search me-2"></i>

                            Charger les élèves

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>






    <!-- Tableau des élèves -->

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <div>

                <i class="fas fa-users me-2"></i>

                Élèves de la classe CM1

            </div>

            <span class="badge bg-primary">

                Français - Composition 1

            </span>

        </div>



        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="70">
                                N°
                            </th>

                            <th>
                                Nom
                            </th>

                            <th>
                                Prénom
                            </th>

                            <th width="170">
                                Note /20
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td>1</td>

                            <td>Diallo</td>

                            <td>Moussa</td>

                            <td>

                                <input
                                    type="number"
                                    class="form-control"
                                    min="0"
                                    max="20"
                                    step="0.25"
                                    placeholder="Note"
                                >

                            </td>

                        </tr>

                        <tr>

                            <td>2</td>

                            <td>Sow</td>

                            <td>Aminata</td>

                            <td>

                                <input
                                    type="number"
                                    class="form-control"
                                    min="0"
                                    max="20"
                                    step="0.25"
                                    placeholder="Note"
                                >

                            </td>

                        </tr>

                        <tr>

                            <td>3</td>

                            <td>Ba</td>

                            <td>Ousmane</td>

                            <td>

                                <input
                                    type="number"
                                    class="form-control"
                                    min="0"
                                    max="20"
                                    step="0.25"
                                    placeholder="Note"
                                >

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>



        <div class="card-footer d-flex justify-content-end">

            <a
                href="/Gestion_Ecole_Primaire/evaluations/liste.php"
                class="btn btn-secondary me-2"
            >

                Retour

            </a>

            <button
                type="submit"
                class="btn btn-success"
            >

                <i class="fas fa-save me-1"></i>

                Enregistrer les notes

            </button>

        </div>

    </div>

</div>
<?php include_once('../includes/footer.php'); ?>
