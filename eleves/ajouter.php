<?php
    include_once('../includes/auth_check.php');
?>
<div class="container-fluid px-4">

        <!-- Titre -->
        <h1 class="mt-4">
            Ajouter un Élève
        </h1>

        <ol class="breadcrumb mb-4">

            <li class="breadcrumb-item">
                <a href="../index.php">
                    Dashboard
                </a>
            </li>

            <li class="breadcrumb-item active">
                Ajouter un élève
            </li>

        </ol>

        <!-- Carte formulaire -->
        <div class="card mb-4">

            <div class="card-header">

                <i class="fas fa-user-plus me-1"></i>

                Formulaire d'inscription

            </div>

            <div class="card-body">

                <form action="../traitements/traiter_ajout.php" method="POST">

                    <!-- Nom et prénom -->
                    <div class="row mb-3">

                        <div class="col-md-6">

                            <label class="form-label">
                                Nom
                            </label>

                            <input type="text"
                                   name="nom"
                                   class="form-control"
                                   placeholder="Entrez le nom"
                                   required>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">
                                Prénom
                            </label>

                            <input type="text"
                                   name="prenom"
                                   class="form-control"
                                   placeholder="Entrez le prénom"
                                   required>

                        </div>

                    </div>

                    <!-- Sexe et date naissance -->
                    <div class="row mb-3">

                        <div class="col-md-6">

                            <label class="form-label">
                                Sexe
                            </label>

                            <select name="sexe"
                                    class="form-select"
                                    required>

                                <option value="">
                                    Choisir
                                </option>

                                <option value="Masculin">
                                    Masculin
                                </option>

                                <option value="Féminin">
                                    Féminin
                                </option>

                            </select>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">
                                Date de naissance
                            </label>

                            <input type="date"
                                   name="date_naissance"
                                   class="form-control"
                                   required>

                        </div>

                    </div>

                    <!-- Adresse -->
                    <div class="mb-3">

                        <label class="form-label">
                            Adresse
                        </label>

                        <textarea name="adresse"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Adresse complète de l'élève"
                                  required></textarea>

                    </div>

                    <!-- Classe et année scolaire -->
                    <div class="row mb-4">

                        <div class="col-md-6">

                            <label class="form-label">
                                Classe
                            </label>

                            <select name="classe"
                                    class="form-select"
                                    required>

                                <option value="">
                                    Choisir une classe
                                </option>

                                <option value="CI">
                                    CI
                                </option>

                                <option value="CP">
                                    CP
                                </option>

                                <option value="CE1">
                                    CE1
                                </option>

                                <option value="CE2">
                                    CE2
                                </option>

                                <option value="CM1">
                                    CM1
                                </option>

                                <option value="CM2">
                                    CM2
                                </option>

                            </select>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">
                                Année scolaire
                            </label>

                            <select name="annee_scolaire"
                                    class="form-select"
                                    required>

                                <option value="">
                                    Choisir l'année scolaire
                                </option>

                                <option value="2025-2026">
                                    2025-2026
                                </option>

                                <option value="2026-2027">
                                    2026-2027
                                </option>

                            </select>

                        </div>

                    </div>

                    <!-- Boutons -->
                    <div class="d-flex justify-content-between">

                        <a href="liste.php"
                           class="btn btn-secondary">

                            Retour

                        </a>

                        <button type="submit"
                                class="btn btn-primary">

                            Inscrire l'élève

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>