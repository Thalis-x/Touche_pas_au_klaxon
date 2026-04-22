<?php
/**
 * Liste des employés (admin).
 * Variables : $employes
 */

use App\Core\View;
?>

<h2 class="mb-4">Utilisateurs</h2>

<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Rôle</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($employes as $employe): ?>
            <tr>
                <td><?= View::e($employe['nom']) ?></td>
                <td><?= View::e($employe['prenom']) ?></td>
                <td><?= View::e($employe['email']) ?></td>
                <td><?= View::e($employe['telephone']) ?></td>
                <td>
                    <?php if ($employe['role'] === 'admin'): ?>
                        <span class="badge bg-danger">Admin</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Utilisateur</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>