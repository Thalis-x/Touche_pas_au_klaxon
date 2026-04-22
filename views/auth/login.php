<?php
/**
 * Formulaire de connexion.
 */

use App\Core\View;
?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <h2 class="mb-4">Connexion</h2>

        <form method="POST" action="/login">
            <div class="mb-3">
                <label for="email" class="form-label">Adresse email</label>
                <input type="email"
                       class="form-control"
                       id="email"
                       name="email"
                       required
                       autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password"
                       class="form-control"
                       id="password"
                       name="password"
                       required>
            </div>

            <button type="submit" class="btn btn-dark w-100">Se connecter</button>
        </form>
    </div>
</div>