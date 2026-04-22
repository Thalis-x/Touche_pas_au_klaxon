<?php
/**
 * Page d'accueil - Liste des trajets disponibles.
 * Variables disponibles : $trajets, $user
 */

use App\Core\View;
?>

<p class="text-muted fs-5">Pour obtenir plus d'informations sur un trajet, veuillez vous connecter</p>

<h2>Trajets proposés</h2>

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
            <?php if ($user): ?>
                <th></th>
            <?php endif; ?>
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
                <td><?= (int) $trajet['nb_places_disponibles'] ?></td>
                <?php if ($user): ?>
                    <td class="text-end">
                        <!-- Bouton détails (modale) -->
                        <button class="btn btn-sm btn-outline-secondary"
                                data-bs-toggle="modal"
                                data-bs-target="#modal-<?= (int) $trajet['id_trajet'] ?>">
                            <i class="bi bi-eye"></i>
                        </button>

                        <?php if ((int) $trajet['id_employe'] === (int) $user['id_employe']): ?>
                            <!-- Modifier -->
                            <a href="/trajet/edit/<?= (int) $trajet['id_trajet'] ?>"
                               class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <!-- Supprimer -->
                            <form method="POST" action="/trajet/delete/<?= (int) $trajet['id_trajet'] ?>"
                                  class="d-inline"
                                  onsubmit="return confirm('Supprimer ce trajet ?')">
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                    </td>
                <?php endif; ?>
            </tr>

            <?php if ($user): ?>
                <!-- Modale détails -->
                <div class="modal fade" id="modal-<?= (int) $trajet['id_trajet'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Détails du trajet</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Auteur :</strong> <?= View::e($trajet['employe_prenom'] . ' ' . $trajet['employe_nom']) ?></p>
                                <p><strong>Téléphone :</strong> <?= View::e($trajet['employe_telephone']) ?></p>
                                <p><strong>Email :</strong> <?= View::e($trajet['employe_email']) ?></p>
                                <p><strong>Nombre total de places :</strong> <?= (int) $trajet['nb_places_total'] ?></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>