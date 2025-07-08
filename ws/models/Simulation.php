<?php
class Simulation {

    // Calcul du tableau d'amortissement avec assurance en pourcentage
    public static function amortissement($C, $t, $n, $a) {
        $A = $C * ($t * pow(1 + $t, $n)) / (pow(1 + $t, $n) - 1);
        $reste = $C;
        $table = [];

        $startDate = new DateTime();

        $assuranceMensuelle = $C * $a ;

        for ($k = 1; $k <= $n; $k++) {
            $Bkm1 = $reste;
            $Ik = $Bkm1 * $t;
            $Vk = $A - $Ik;
            $reste = $Bkm1 * (1 + $t) - $A;

            $d = clone $startDate;
            $d->modify("+".($k-1)." months");

            $table[] = [
                'mois'            => $d->format('F'),
                'annee'           => (int)$d->format('Y'),
                'capital_debut'   => round($Bkm1, 2),
                'interet'         => round($Ik, 2),
                'amortissement'   => round($Vk, 2),
                'assurance'       => round($assuranceMensuelle, 2),
                'reste'           => round($reste, 2),
            ];
        }

        $table[] = [
            'mois'          => 'Total',
            'annee'         => '',
            'capital_debut' => '',
            'interet'       => '',
            'amortissement' => '',
            'assurance'     => round($assuranceMensuelle * $n, 2),
            'reste'         => round(($A + $assuranceMensuelle) * $n, 2),
        ];

        return $table;
    }

    // Calcul total à rembourser (annuité + assurance)
    public static function calculTotalRembourse($C, $t, $n, $a) {
        $A = $C * ($t * pow(1 + $t, $n)) / (pow(1 + $t, $n) - 1);
        $Aass = $C * ($a);
        return ($A + $Aass) * $n;
    }
}
