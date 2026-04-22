<?php
/**
 * Formulaire de modification d'une agence.
 * Variables : $agence
 */

use App\Core\View;
?>

<h2 class="mb-4">Modifier l'agence</h2>

<form method="POST" action="/admin/agences/edit/<?= (int) $agence['id_agence'] ?>">
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="nom_ville" class="form-label">Nom de la ville</label>
            <input type="text" class="form-control" id="nom_ville" name="nom_ville"
                   value="<?= View::e($agence['nom_ville']) ?>" required autofocus>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-dark">Enregistrer</button>
        <a href="/admin/agences" class="btn btn-outline-secondary">Annuler</a>
    </div>
</form>