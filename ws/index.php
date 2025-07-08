<?php
require 'vendor/autoload.php';
require 'db.php';
require 'routes/finance_routes.php';
require 'routes/Type_routes.php';
require 'routes/client-routes.php';
require 'routes/Simulation_route.php';
require 'routes/Interet_routes.php';
// Inclure ici les nouveaux fichiers de routes pour la maquette du système financier

Flight::start();