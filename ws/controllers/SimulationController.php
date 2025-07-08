<?php
require_once __DIR__ . '/../models/Simulation.php';

class SimulationController {

    public static function simulate() {
        $data = Flight::request()->data;

        $capital = floatval($data->capital ?? 0);
        $taux = floatval($data->taux ?? 0);
        $duree = intval($data->duree ?? 0);
        $assurance = floatval($data->assurance ?? 0);

        if ($capital <= 0 || $taux <= 0 || $duree <= 0) {
            Flight::halt(400, 'Paramètres invalides');
        }

        // Calcul du tableau d'amortissement
        $tableau = Simulation::amortissement($capital, $taux, $duree, $assurance);

        // Calcul du total remboursé
        $total = Simulation::calculTotalRembourse($capital, $taux, $duree, $assurance);

        Flight::json([
            'tableau' => $tableau,
            'total' => round($total, 2)
        ]);
    }
}
