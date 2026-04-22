<?php
/**
 * Contrôleur des trajets.
 *
 * @package App\Controllers
 */

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Agence;
use App\Models\Trajet;

class TrajetController extends Controller
{
    /**
     * Affiche le formulaire de création d'un trajet.
     */
    public function showCreate(): void
    {
        $this->requireAuth();

        $user    = Session::user();
        $agences = Agence::findAllSorted();

        $this->view('trajet/create', [
            'agences' => $agences,
            'employe' => $user,
        ]);
    }

    /**
     * Traite la création d'un trajet.
     */
    public function create(): void
    {
        $this->requireAuth();

        $user = Session::user();

        // Récupération des données du formulaire
        $agenceDepart  = $this->input('agence_depart');
        $agenceArrivee = $this->input('agence_arrivee');
        $dateDepart    = $this->input('date_depart');
        $heureDepart   = $this->input('heure_depart');
        $dateArrivee   = $this->input('date_arrivee');
        $heureArrivee  = $this->input('heure_arrivee');
        $nbPlaces      = $this->input('nb_places');

        // Contrôles de cohérence
        $errors = $this->validateTrajet(
            $agenceDepart,
            $agenceArrivee,
            $dateDepart,
            $heureDepart,
            $dateArrivee,
            $heureArrivee,
            $nbPlaces
        );

        if (!empty($errors)) {
            $this->redirectWithError('/trajet/create', implode('<br>', $errors));
            return;
        }

        $dateHeureDepart  = $dateDepart . ' ' . $heureDepart . ':00';
        $dateHeureArrivee = $dateArrivee . ' ' . $heureArrivee . ':00';

        Trajet::create([
            'date_heure_depart'     => $dateHeureDepart,
            'date_heure_arrivee'    => $dateHeureArrivee,
            'nb_places_total'       => (int) $nbPlaces,
            'nb_places_disponibles' => (int) $nbPlaces,
            'id_employe'            => (int) $user['id_employe'],
            'id_agence_depart'      => (int) $agenceDepart,
            'id_agence_arrivee'     => (int) $agenceArrivee,
        ]);

        $this->redirectWithSuccess('/', 'Le trajet a été créé avec succès.');
    }

    /**
     * Affiche le formulaire de modification d'un trajet.
     */
    public function showEdit(int $id): void
    {
        $this->requireAuth();

        $trajet = Trajet::findWithDetails($id);
        $user   = Session::user();

        if (!$trajet || (int) $trajet['id_employe'] !== (int) $user['id_employe']) {
            $this->redirectWithError('/', 'Vous ne pouvez pas modifier ce trajet.');
            return;
        }

        $agences = Agence::findAllSorted();

        $this->view('trajet/edit', [
            'trajet'  => $trajet,
            'agences' => $agences,
            'employe' => $user,
        ]);
    }

    /**
     * Traite la modification d'un trajet.
     */
    public function update(int $id): void
    {
        $this->requireAuth();

        $trajet = Trajet::findById($id);
        $user   = Session::user();

        if (!$trajet || (int) $trajet['id_employe'] !== (int) $user['id_employe']) {
            $this->redirectWithError('/', 'Vous ne pouvez pas modifier ce trajet.');
            return;
        }

        $agenceDepart  = $this->input('agence_depart');
        $agenceArrivee = $this->input('agence_arrivee');
        $dateDepart    = $this->input('date_depart');
        $heureDepart   = $this->input('heure_depart');
        $dateArrivee   = $this->input('date_arrivee');
        $heureArrivee  = $this->input('heure_arrivee');
        $nbPlaces      = $this->input('nb_places');
        $nbPlacesDispo = $this->input('nb_places_disponibles');

        $errors = $this->validateTrajet(
            $agenceDepart,
            $agenceArrivee,
            $dateDepart,
            $heureDepart,
            $dateArrivee,
            $heureArrivee,
            $nbPlaces
        );

        if ($nbPlacesDispo !== null && (int) $nbPlacesDispo > (int) $nbPlaces) {
            $errors[] = 'Les places disponibles ne peuvent pas dépasser le total.';
        }

        if (!empty($errors)) {
            $this->redirectWithError('/trajet/edit/' . $id, implode('<br>', $errors));
            return;
        }

        $dateHeureDepart  = $dateDepart . ' ' . $heureDepart . ':00';
        $dateHeureArrivee = $dateArrivee . ' ' . $heureArrivee . ':00';

        Trajet::updateTrajet($id, [
            'date_heure_depart'     => $dateHeureDepart,
            'date_heure_arrivee'    => $dateHeureArrivee,
            'nb_places_total'       => (int) $nbPlaces,
            'nb_places_disponibles' => (int) ($nbPlacesDispo ?? $nbPlaces),
            'id_agence_depart'      => (int) $agenceDepart,
            'id_agence_arrivee'     => (int) $agenceArrivee,
        ]);

        $this->redirectWithSuccess('/', 'Le trajet a été modifié.');
    }

    /**
     * Supprime un trajet.
     */
    public function delete(int $id): void
    {
        $this->requireAuth();

        $trajet = Trajet::findById($id);
        $user   = Session::user();

        if (!$trajet || (int) $trajet['id_employe'] !== (int) $user['id_employe']) {
            $this->redirectWithError('/', 'Vous ne pouvez pas supprimer ce trajet.');
            return;
        }

        Trajet::deleteById($id);
        $this->redirectWithSuccess('/', 'Le trajet a été supprimé.');
    }

    /**
     * Valide les données d'un trajet.
     *
     * @return string[] Liste des erreurs
     */
    private function validateTrajet(
        ?string $agenceDepart,
        ?string $agenceArrivee,
        ?string $dateDepart,
        ?string $heureDepart,
        ?string $dateArrivee,
        ?string $heureArrivee,
        ?string $nbPlaces
    ): array {
        $errors = [];

        if (!$agenceDepart || !$agenceArrivee || !$dateDepart || !$heureDepart || !$dateArrivee || !$heureArrivee || !$nbPlaces) {
            $errors[] = 'Tous les champs sont obligatoires.';
            return $errors;
        }

        if ($agenceDepart === $agenceArrivee) {
            $errors[] = "L'agence de départ et d'arrivée doivent être différentes.";
        }

        $depart  = strtotime("$dateDepart $heureDepart");
        $arrivee = strtotime("$dateArrivee $heureArrivee");

          if ($depart && $depart <= time()) {
            $errors[] = 'La date de départ doit être dans le futur.';
        }

        if ($depart && $arrivee && $arrivee <= $depart) {
            $errors[] = "La date d'arrivée doit être postérieure à la date de départ.";
        }

        if ((int) $nbPlaces < 1) {
            $errors[] = 'Le nombre de places doit être au minimum 1.';
        }
        if ((int) $nbPlaces > 7) {
            $errors[] = 'Le nombre de places doit être au maximum 7.';
        }

        return $errors;
    }
}