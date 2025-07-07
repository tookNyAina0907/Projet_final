<?php
require_once __DIR__ . '/../models/Client.php';

class ClientController {
    public static function getAll() {
        $clients = Client::getAll();
        Flight::json($clients);
    }

    public static function getById($id) {
        $client = Client::getById($id);
        if ($client) {
            Flight::json($client);
        } else {
            Flight::halt(404, 'Client non trouvé');
        }
    }

    public static function create() {
        $data = Flight::request()->data;
        Client::insert($data);
        Flight::json(['message' => 'Client ajouté avec succès']);
    }

    public static function update($id) {
        $data = Flight::request()->data;
        Client::update($id, $data);
        Flight::json(['message' => 'Client mis à jour avec succès']);
    }

    public static function delete($id) {
        Client::delete($id);
        Flight::json(['message' => 'Client supprimé avec succès']);
    }
    
}
