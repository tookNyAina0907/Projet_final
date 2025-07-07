<?php
// Routes principales pour la maquette du système financier
Flight::route('GET /', function() {
    include __DIR__.'/../views/home.php';
});
Flight::route('GET /clients', function() {
    include __DIR__.'/../views/clients.php';
});
Flight::route('GET /ajout-fond', function() {
    include __DIR__.'/../views/ajout-fond.php';
});
Flight::route('GET /type-pret', function() {
    include __DIR__.'/../views/type-pret.php';
});
Flight::route('GET /ajouter-pret', function() {
    include __DIR__.'/../views/ajouter-pret.php';
});
Flight::route('GET /simulation', function() {
    include __DIR__.'/../views/simulation.php';
});
Flight::route('GET /pret-client', function() {
    include __DIR__.'/../views/pret-client.php';
});
Flight::route('GET /remboursements', function() {
    include __DIR__.'/../views/remboursements.php';
});
Flight::route('GET /interets', function() {
    include __DIR__.'/../views/interets.php';
});
Flight::route('GET /pdf-pret', function() {
    include __DIR__.'/../views/pdf-pret.php';
});
Flight::route('GET /ajouter-client', function() {
    include __DIR__.'/../views/ajouter-client.php';
}); 