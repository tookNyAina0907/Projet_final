<?php
require_once __DIR__ . '/../controllers/SimulationController.php';

Flight::route('POST /simulate', ['SimulationController', 'simulate']);