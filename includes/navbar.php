<nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">

    <!-- Logo / Nom école -->
    <a class="navbar-brand ps-3" href="../index.php">
        École Primaire ANA
    </a>

    <!-- Bouton toggle sidebar -->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle">

        <i class="fas fa-bars"></i>

    </button>

    <!-- Recherche (optionnel pour dashboard) -->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">

        <div class="input-group">

            <input class="form-control" type="text" placeholder="Rechercher..." />

            <button class="btn btn-light" type="button">
                <i class="fas fa-search"></i>
            </button>

        </div>

    </form>

    <!-- Menu utilisateur -->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">

        <li class="nav-item dropdown">

            <a class="nav-link dropdown-toggle"
               id="navbarDropdown"
               href="#"
               role="button"
               data-bs-toggle="dropdown">

                <i class="fas fa-user fa-fw"></i>

            </a>

            <ul class="dropdown-menu dropdown-menu-end">

                <li>
                    <a class="dropdown-item" href="#">
                        Profil
                    </a>
                </li>

                <li>
                    <a class="dropdown-item" href="#">
                        Paramètres
                    </a>
                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>
                    <a class="dropdown-item" href="/Gestion_Ecole_Primaire/auth/logout.php">
                        Déconnexion
                    </a>
                </li>

            </ul>

        </li>

    </ul>

</nav>
