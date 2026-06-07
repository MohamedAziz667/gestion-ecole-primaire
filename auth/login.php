<?php include('../includes/auth_include/auth_header.php'); ?>
<main class="auth-container">

    <div class="card auth-card">

        <div class="card-body p-5">

            <!-- Titre -->
            <div class="mb-4 text-center">

                <h2 class="auth-title">
                    École Primaire ANA
                </h2>

                <p class="text-muted">
                    Connexion à l'application de gestion
                </p>

            </div>

            <!-- Message d'erreur (caché par défaut) -->
            <div class="alert alert-danger d-none" role="alert">
                Matricule ou mot de passe incorrect.
            </div>

            <!-- Formulaire -->
            <form action="../traitements/traiter_login.php" method="POST">

                <!-- Matricule -->
                <div class="mb-3">

                    <label class="form-label">
                        Matricule
                    </label>

                    <input type="text"
                           name="matricule"
                           class="form-control"
                           placeholder="Entrer votre matricule"
                           required>

                </div>

                <!-- Mot de passe -->
                <div class="mb-4">

                    <label class="form-label">
                        Mot de passe
                    </label>

                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="Entrer votre mot de passe"
                           required>

                </div>

                <!-- Bouton -->
                <div class="d-grid">

                    <button type="submit"
                            class="btn btn-primary" name="se_connecter">
                        Se connecter
                    </button>

                </div>

            </form>

        </div>

    </div>

</main>
<?php include('../includes/auth_include/auth_footer.php'); ?>