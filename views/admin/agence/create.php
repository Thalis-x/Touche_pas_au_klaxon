<?php
/**
 * Formulaire de création d'une agence.
 */
?>

<h2 class="mb-4">Ajouter une agence</h2>

<form method="POST" action="/admin/agences/create">
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="nom_ville" class="form-label">Nom de la ville</label>
            <input type="text" class="form-control" id="nom_ville" name="nom_ville" required autofocus>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-dark">Ajouter</button>
        <a href="/admin/agences" class="btn btn-outline-secondary">Annuler</a>
    </div>
</form>