<?php
require_once __DIR__ . '/../db.php';

class Interet {

    // Insère un enregistrement d'intérêt
    public static function insert($client_id, $mois, $montant) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO interet (client_id, mois, montant) VALUES (?, ?, ?)");
        $stmt->execute([$client_id, $mois, $montant]);
    }

    // Récupère tous les intérêts d'un client
    public static function getByClientId($client_id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM interet WHERE client_id = ? ORDER BY mois ASC");
        $stmt->execute([$client_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Supprime tous les intérêts d'un client (optionnel)
    public static function deleteByClientId($client_id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM interet WHERE client_id = ?");
        $stmt->execute([$client_id]);
    }
 public static function getByDate($datedebut, $datefin) {
    $db = getDB();
    $stmt = $db->prepare("
        SELECT DATE_FORMAT(mois, '%m/%Y') AS mois, SUM(montant) AS total
        FROM interet
        WHERE mois BETWEEN ? AND LAST_DAY(?)
        GROUP BY mois
        ORDER BY mois
    ");
    $stmt->execute([$datedebut . '-01', $datefin . '-01']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

        
}
