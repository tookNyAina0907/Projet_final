<?php
require_once __DIR__ . '/../models/Type.php';

class TypeControllers {
    public static function getAll() {
        $types = Type::getAll();
        Flight::json($types);
    }

    public static function getById($id) {
        $type = Type::getById($id);
        if ($type) {
            Flight::json($type);
        } else {
            Flight::halt(404, 'Type de prêt non trouvé');
        }
    }

    public static function create() {
        $data = Flight::request()->data;

        // Protection : validation minimale
        $nom = isset($data->nom) ? $data->nom : null;
        $taux = isset($data->taux) ? $data->taux : null;
        $assurance = isset($data->assurance) ? $data->assurance : null;

        if (!$nom || !is_numeric($taux)) {
            Flight::halt(400, 'Champs nom ou taux manquants ou invalides');
        }

        $data->assurance = $assurance; // même null autorisé
        $id = Type::create($data);
        Flight::json(['message' => 'Type de prêt ajouté', 'id' => $id]);
    }

    public static function update($id) {
        $data = Flight::request()->data;

        $nom = isset($data->nom) ? $data->nom : null;
        $taux = isset($data->taux) ? $data->taux : null;
        $assurance = isset($data->assurance) ? $data->assurance : null;

        if (!$nom || !is_numeric($taux)) {
            Flight::halt(400, 'Champs nom ou taux manquants ou invalides');
        }

        $data->assurance = $assurance;
        Type::update($id, $data);
        Flight::json(['message' => 'Type de prêt modifié']);
    }

    public static function delete($id) {
        Type::delete($id);
        Flight::json(['message' => 'Type de prêt supprimé']);
    }
}
