<?php
require_once __DIR__ . '/../models/Fond.php';

class FondController {
    public static function getFond() {
        $fond = Fond::get();
        Flight::json($fond);
    }

    public static function ajouterFond() {
        $data = Flight::request()->data;
        $montant = floatval($data->montant ?? 0);

        if ($montant > 0) {
            Fond::ajouter($montant);
            Flight::json(['message' => 'Fonds ajoutés avec succès']);
        } else {
            Flight::halt(400, "Montant invalide");
        }
    }
}
