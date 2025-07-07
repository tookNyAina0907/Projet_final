<?php
require_once __DIR__ . '/../models/Type.php';
require_once __DIR__ . '/../helpers/Utils.php';

class TypeControllers {
    public static function getAll() {
        $types = Type::getAll();
        Flight::json($types);
    }

    public static function getById($id) {
        $type = Type::getById($id);
        Flight::json($type);
    }

    public static function create() {
        $data = Flight::request()->data;
        $id = Type::create($data);
        // $dateFormatted = Utils::formatDate('2025-01-01'); // si ce champ n’est pas utile ici, tu peux le retirer
        Flight::json(['message' => 'Type de prêt ajouté', 'id' => $id]);
    }

    public static function update($id) {
        $data = Flight::request()->data;
        Type::update($id, $data);
        Flight::json(['message' => 'Type de prêt modifié']);
    }

    public static function delete($id) {
        Type::delete($id);
        Flight::json(['message' => 'Type de prêt supprimé']);
    }
}
