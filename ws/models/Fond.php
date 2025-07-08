<?php
require_once __DIR__ . '/../db.php';

class Fond {
    public static function get() {
        $db = getDB();
        $stmt = $db->prepare("SELECT fond FROM etablissement WHERE id = 1");
        $stmt->execute();
        return ['fond' => $stmt->fetchColumn()];
    }

    public static function ajouter($montant) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE etablissement SET fond = fond + ? WHERE id = 1");
        $stmt->execute([$montant]);
    }
}
