<?php
require_once __DIR__ . '/../controllers/TypeControllers.php';

Flight::route('GET /types', ['TypeControllers', 'getAll']);
Flight::route('GET /types/@id', ['TypeControllers', 'getById']);
Flight::route('POST /types', ['TypeControllers', 'create']);
Flight::route('PUT /types/@id', ['TypeControllers', 'update']);
Flight::route('DELETE /types/@id', ['TypeControllers', 'delete']);
