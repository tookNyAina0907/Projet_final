<?php
require_once __DIR__ . '/../models/Interet.php';

class InteretController {

    public static function getAllByClient($client_id) {
        $interets = Interet::getByClientId($client_id);
        Flight::json($interets);
    }

    public static function create() {
        $data = Flight::request()->data;
        if (!isset($data->client_id, $data->mois, $data->montant)) {
            Flight::halt(400, 'Données manquantes');
        }
        Interet::insert($data->client_id, $data->mois, $data->montant);
        Flight::json(['message' => 'Intérêt ajouté avec succès']);
    }

    public static function deleteByClient($client_id) {
        Interet::deleteByClientId($client_id);
        Flight::json(['message' => 'Intérêts supprimés avec succès']);
    }
}
