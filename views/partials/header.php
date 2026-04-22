<?php
/**
 * Header de l'application.
 * Variables disponibles : $appName, $user
 */

use App\Core\View;
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom py-3">
    <div class="container">
        <?php if ($user && $user['role'] === 'admin'): ?>
            <a class="navbar-brand fw-bold" href="/admin"><?= View::e($appName) ?></a>
        <?php else: ?>
            <span class="navbar-brand fw-bold"><?= View::e($appName) ?></span>
        <?php endif; ?>

        <div class="d-flex align-items-center gap-2">
            <?php if (!$user): ?>
                <!-- Visiteur non connecté -->
                <a href="/login" class="btn btn-dark">Connexion</a>

            <?php elseif ($user['role'] === 'admin'): ?>
                <!-- Administrateur -->
                <a href="/admin/employes" class="btn btn-secondary">Utilisateurs</a>
                <a href="/admin/agences" class="btn btn-secondary">Agences</a>
                <a href="/admin/trajets" class="btn btn-secondary">Trajets</a>
                <span class="ms-2">Bonjour <?= View::e($user['prenom'] . ' ' . $user['nom']) ?></span>
                <a href="/logout" class="btn btn-dark">Déconnexion</a>

            <?php else: ?>
                <!-- Utilisateur connecté -->
                <a href="/trajet/create" class="btn btn-dark">Créer un trajet</a>
                <span class="ms-2">Bonjour <?= View::e($user['prenom'] . ' ' . $user['nom']) ?></span>
                <a href="/logout" class="btn btn-dark">Déconnexion</a>
            <?php endif; ?>
        </div>
    </div>
</nav>