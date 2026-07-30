<div id="layoutSidenav">

    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">

            <div class="sb-sidenav-menu">

                <div class="nav">

                    <div class="sb-sidenav-menu-heading">Navigation</div>

                    <!-- Tableau de bord -->
                    <a class="nav-link" href="/Gestion_Ecole_Primaire/index.php">
                        <div class="sb-nav-link-icon">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                        Tableau de bord
                    </a>

                    <!-- Classes -->
                    <div class="sb-sidenav-menu-heading">Gestion académique</div>

                    <a class="nav-link collapsed"
                       href="#"
                       data-bs-toggle="collapse"
                       data-bs-target="#collapseClasses"
                       aria-expanded="false"
                       aria-controls="collapseClasses">

                        <div class="sb-nav-link-icon">
                            <i class="fas fa-school"></i>
                        </div>

                        Classes

                        <div class="sb-sidenav-collapse-arrow">
                            <i class="fas fa-angle-down"></i>
                        </div>

                    </a>

                    <div class="collapse"
                         id="collapseClasses"
                         data-bs-parent="#sidenavAccordion">

                        <nav class="sb-sidenav-menu-nested nav">

                            <a class="nav-link"
                               href="/Gestion_Ecole_Primaire/classes/liste.php">
                                Liste des classes
                            </a>

                            <a class="nav-link"
                               href="/Gestion_Ecole_Primaire/classes/ajouter.php">
                                Ajouter une classe
                            </a>

                            <a class="nav-link"
                               href="/Gestion_Ecole_Primaire/classes/detail.php">
                                detail des classes
                            </a>

                        </nav>

                    </div>

                    <!-- Enseignants -->

                    <a class="nav-link collapsed"
                       href="#"
                       data-bs-toggle="collapse"
                       data-bs-target="#collapseEnseignants"
                       aria-expanded="false"
                       aria-controls="collapseEnseignants">

                        <div class="sb-nav-link-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>

                        Enseignants

                        <div class="sb-sidenav-collapse-arrow">
                            <i class="fas fa-angle-down"></i>
                        </div>

                    </a>

                    <div class="collapse"
                         id="collapseEnseignants"
                         data-bs-parent="#sidenavAccordion">

                        <nav class="sb-sidenav-menu-nested nav">

                            <a class="nav-link"
                               href="/Gestion_Ecole_Primaire/enseignants/liste.php">
                                Liste des enseignants
                            </a>

                            <a class="nav-link"
                               href="/Gestion_Ecole_Primaire/enseignants/ajouter.php">
                                Ajouter un enseignant
                            </a>

                        </nav>

                    </div>

                    <!-- Inscriptions -->

                    <a class="nav-link collapsed"
                       href="#"
                       data-bs-toggle="collapse"
                       data-bs-target="#collapseInscriptions"
                       aria-expanded="false"
                       aria-controls="collapseInscriptions">

                        <div class="sb-nav-link-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>

                        Inscriptions

                        <div class="sb-sidenav-collapse-arrow">
                            <i class="fas fa-angle-down"></i>
                        </div>

                    </a>

                    <div class="collapse"
                         id="collapseInscriptions"
                         data-bs-parent="#sidenavAccordion">

                        <nav class="sb-sidenav-menu-nested nav">

                            <a class="nav-link"
                               href="/Gestion_Ecole_Primaire/inscriptions/liste.php">
                                Liste des inscriptions
                            </a>

                            <a class="nav-link"
                               href="/Gestion_Ecole_Primaire/inscriptions/ajouter.php">
                                Ajouter une inscription
                            </a>

                        </nav>

                    </div>

                    <!-- Évaluations -->

                    <a class="nav-link collapsed"
                       href="#"
                       data-bs-toggle="collapse"
                       data-bs-target="#collapseEvaluations"
                       aria-expanded="false"
                       aria-controls="collapseEvaluations">

                        <div class="sb-nav-link-icon">
                            <i class="fas fa-file-signature"></i>
                        </div>

                        Évaluations

                        <div class="sb-sidenav-collapse-arrow">
                            <i class="fas fa-angle-down"></i>
                        </div>

                    </a>

                    <div class="collapse"
                         id="collapseEvaluations"
                         data-bs-parent="#sidenavAccordion">

                        <nav class="sb-sidenav-menu-nested nav">

                            <a class="nav-link"
                               href="/Gestion_Ecole_Primaire/evaluations/liste.php">
                                Liste des évaluations
                            </a>

                            <a class="nav-link"
                               href="/Gestion_Ecole_Primaire/evaluations/ajouter.php">
                                Ajouter une évaluation
                            </a>

                        </nav>

                    </div>

                    <!-- Paramètres -->
                    <!-- Cette classe permettra de masquer facilement le menu avec PHP -->
                    <div class="menu-directeur">

                        <a class="nav-link collapsed"
                           href="#"
                           data-bs-toggle="collapse"
                           data-bs-target="#collapseParametres"
                           aria-expanded="false"
                           aria-controls="collapseParametres">

                            <div class="sb-nav-link-icon">
                                <i class="fas fa-cogs"></i>
                            </div>

                            Paramètres

                            <div class="sb-sidenav-collapse-arrow">
                                <i class="fas fa-angle-down"></i>
                            </div>

                        </a>

                        <div class="collapse"
                             id="collapseParametres"
                             data-bs-parent="#sidenavAccordion">

                            <nav class="sb-sidenav-menu-nested nav">

                                <a class="nav-link"
                                   href="/Gestion_Ecole_Primaire/parametres/annees.php">
                                    Années scolaires
                                </a>

                                <a class="nav-link"
                                   href="/Gestion_Ecole_Primaire/parametres/matieres.php">
                                    Matières
                                </a>

                                <a class="nav-link"
                                   href="/Gestion_Ecole_Primaire/parametres/compositions.php">
                                    Compositions
                                </a>

                                <a class="nav-link"
                                   href="/Gestion_Ecole_Primaire/parametres/utilisateurs.php">
                                    Utilisateurs
                                </a>

                            </nav>

                        </div>

                    </div>

                </div>

            </div>

            <div class="sb-sidenav-footer">
                <div class="small">Connecté en tant que :</div>
                Administrateur
            </div>

        </nav>
    </div>

    <div id="layoutSidenav_content">