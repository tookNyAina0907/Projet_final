<?php
require_once __DIR__ . '/../controllers/InteretController.php';

// Récupérer tous les intérêts d'un client
Flight::route('GET /interets/client/@client_id', ['InteretController', 'getAllByClient']);

// Ajouter un intérêt (POST avec JSON {client_id, mois, montant})
Flight::route('POST /interets', ['InteretController', 'create']);

// Supprimer tous les intérêts d'un client
Flight::route('DELETE /interets/client/@client_id', ['InteretController', 'deleteByClient']);
