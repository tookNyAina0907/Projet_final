<?php
class Simulation {

    /**
     * Calcul du tableau d'amortissement avec amortissement constant et assurance
     * @param float $C Capital emprunté
     * @param float $t Taux d'intérêt mensuel (ex: 6.5%/12)
     * @param int   $n Nombre de mensualités
     * @param float $a Taux d'assurance annuel (ex: 0.5% = 0.005)
     * @return array Tableau d'amortissement
     */
    public static function amortissement($C, $t, $n, $a) {
    // Calcul de la mensualité (annuité constante)
    $A = $C * ($t * pow(1 + $t, $n)) / (pow(1 + $t, $n) - 1);
    $reste = $C;
    $table = [];
    $startDate = new DateTime();

    // Assurance mensuelle (taux annuel divisé par 12)
    $assuranceMensuelle = ($C * $a);

    // Totaux
    $totalInterets = 0;
    $totalMensualite = 0;

    for ($k = 1; $k <= $n; $k++) {
        $Bkm1 = $reste;
        $interet = $Bkm1 * $t;
        $principal = $A -$interet;
        $mensualite = $A + $assuranceMensuelle;

        $d = (clone $startDate)->modify('+' . ($k - 1) . ' months');

        $table[] = [
            'mois'          => $d->format('F'),
            'annee'         => (int)$d->format('Y'),
            'capital_debut' => round($Bkm1, 2),
            'interet'       => round($interet, 2),
            'amortissement'=> round($A, 2),
            'assurance'     => round($assuranceMensuelle, 2),
            'mensualite'    => round($mensualite, 2),
            'reste'         => round(max(0, $reste - $principal), 2),
        ];

        // Mise à jour du reste et des totaux
        $reste -= $principal;
        $totalInterets += $interet;
        $totalMensualite += $mensualite;
    }

    // Ajout de la ligne Totale
    $table[] = [
        'mois'          => 'Total',
        'annee'         => '',
        'capital_debut' => '',
        'interet'       => round($totalInterets, 2),
        'amortissement'=> round($C, 2),
        'assurance'     => round($assuranceMensuelle * $n, 2),
        'reste'         => '',
        'mensualite'    => round($totalMensualite, 2),
    ];

    return $table;
}

    /**
     * Calcul du total à rembourser (capital + intérêts + assurance)
     * @return float
     */
    public static function calculTotalRembourse($C, $t, $n, $a) {
        $schedule = self::amortissement($C, $t, $n, $a);
        $totalInterets = 0;
        foreach ($schedule as $row) {
            if ($row['mois'] !== 'Total') {
                $totalInterets += $row['interet'];
            }
        }
        $totalAssurance = ($C * $a) * $n;
        return round($C + $totalInterets + $totalAssurance, 2);
    }
}
