<?php
/**
 * Formulaire de modification d'un trajet.
 * Variables : $trajet, $agences, $employe
 */

use App\Core\View;
?>

<h2 class="mb-4">Modifier le trajet</h2>

<form method="POST" action="/trajet/edit/<?= (int) $trajet['id_trajet'] ?>">
    <!-- Infos employé (non modifiables) -->
    <div class="row mb-3">
        <div class="col-md-3">
            <label class="form-label">Nom</label>
            <input type="text" class="form-control" value="<?= View::e($employe['nom']) ?>" disabled>
        </div>
        <div class="col-md-3">
            <label class="form-label">Prénom</label>
            <input type="text" class="form-control" value="<?= View::e($employe['prenom']) ?>" disabled>
        </div>
        <div class="col-md-3">
            <label class="form-label">Email</label>
            <input type="text" class="form-control" value="<?= View::e($employe['email']) ?>" disabled>
        </div>
        <div class="col-md-3">
            <label class="form-label">Téléphone</label>
            <input type="text" class="form-control" value="<?= View::e($employe['telephone']) ?>" disabled>
        </div>
    </div>

    <hr>

    <!-- Départ -->
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="agence_depart" class="form-label">Agence de départ</label>
            <select class="form-select" id="agence_depart" name="agence_depart" required>
                <?php foreach ($agences as $agence): ?>
                    <option value="<?= (int) $agence['id_agence'] ?>"
                        <?= (int) $agence['id_agence'] === (int) $trajet['id_agence_depart'] ? 'selected' : '' ?>>
                        <?= View::e($agence['nom_ville']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label for="date_depart" class="form-label">Date de départ</label>
            <input type="date" class="form-control" id="date_depart" name="date_depart"
                   value="<?= date('Y-m-d', strtotime($trajet['date_heure_depart'])) ?>" required>
        </div>
        <div class="col-md-4">
            <label for="heure_depart" class="form-label">Heure de départ</label>
            <input type="time" class="form-control" id="heure_depart" name="heure_depart"
                   value="<?= date('H:i', strtotime($trajet['date_heure_depart'])) ?>" required>
        </div>
    </div>

    <!-- Arrivée -->
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="agence_arrivee" class="form-label">Agence d'arrivée</label>
            <select class="form-select" id="agence_arrivee" name="agence_arrivee" required>
                <?php foreach ($agences as $agence): ?>
                    <option value="<?= (int) $agence['id_agence'] ?>"
                        <?= (int) $agence['id_agence'] === (int) $trajet['id_agence_arrivee'] ? 'selected' : '' ?>>
                        <?= View::e($agence['nom_ville']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label for="date_arrivee" class="form-label">Date d'arrivée</label>
            <input type="date" class="form-control" id="date_arrivee" name="date_arrivee"
                   value="<?= date('Y-m-d', strtotime($trajet['date_heure_arrivee'])) ?>" required>
        </div>
        <div class="col-md-4">
            <label for="heure_arrivee" class="form-label">Heure d'arrivée</label>
            <input type="time" class="form-control" id="heure_arrivee" name="heure_arrivee"
                   value="<?= date('H:i', strtotime($trajet['date_heure_arrivee'])) ?>" required>
        </div>
    </div>

    <!-- Places -->
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="nb_places" class="form-label">Nombre total de places</label>
            <input type="number" class="form-control" id="nb_places" name="nb_places"
                   min="1" max="9" value="<?= (int) $trajet['nb_places_total'] ?>" required>
        </div>
        <div class="col-md-4">
            <label for="nb_places_disponibles" class="form-label">Places disponibles</label>
            <input type="number" class="form-control" id="nb_places_disponibles" name="nb_places_disponibles"
                   min="0" max="9" value="<?= (int) $trajet['nb_places_disponibles'] ?>" required>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-dark">Enregistrer</button>
        <a href="/" class="btn btn-outline-secondary">Annuler</a>
    </div>
</form>