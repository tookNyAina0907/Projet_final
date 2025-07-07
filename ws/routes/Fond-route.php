<?php
require_once __DIR__ . '/../controllers/FondController.php';

Flight::route('GET /fonds', ['FondController', 'getFond']);
Flight::route('POST /fonds', ['FondController', 'ajouterFond']);
