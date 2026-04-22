<?php
/**
 * Liste des agences (admin).
 * Variables : $agences
 */

use App\Core\View;
?>

<h2 class="mb-4">Agences</h2>

<a href="/admin/agences/create" class="btn btn-dark mb-3">Ajouter une agence</a>

<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th>Ville</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($agences as $agence): ?>
            <tr>
                <td><?= View::e($agence['nom_ville']) ?></td>
                <td class="text-end">
                    <a href="/admin/agences/edit/<?= (int) $agence['id_agence'] ?>"
                       class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form method="POST" action="/admin/agences/delete/<?= (int) $agence['id_agence'] ?>"
                          class="d-inline"
                          onsubmit="return confirm('Supprimer cette agence ?')">
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>