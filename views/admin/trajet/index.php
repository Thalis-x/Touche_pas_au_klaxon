<?php
/**
 * Liste des trajets (admin).
 * Variables : $trajets
 */

use App\Core\View;
?>

<h2 class="mb-4">Trajets</h2>

<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th>Départ</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Destination</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Places</th>
            <th>Auteur</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($trajets as $trajet): ?>
            <tr>
                <td><?= View::e($trajet['ville_depart']) ?></td>
                <td><?= date('d/m/Y', strtotime($trajet['date_heure_depart'])) ?></td>
                <td><?= date('H:i', strtotime($trajet['date_heure_depart'])) ?></td>
                <td><?= View::e($trajet['ville_arrivee']) ?></td>
                <td><?= date('d/m/Y', strtotime($trajet['date_heure_arrivee'])) ?></td>
                <td><?= date('H:i', strtotime($trajet['date_heure_arrivee'])) ?></td>
                <td><?= (int) $trajet['nb_places_disponibles'] ?> / <?= (int) $trajet['nb_places_total'] ?></td>
                <td><?= View::e($trajet['employe_prenom'] . ' ' . $trajet['employe_nom']) ?></td>
                <td>
                    <form method="POST" action="/admin/trajets/delete/<?= (int) $trajet['id_trajet'] ?>"
                          class="d-inline"
                          onsubmit="return confirm('Supprimer ce trajet ?')">
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>