<?php
require_once __DIR__ . '/../db.php';

class Type {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM type_pret");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM type_pret WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO type_pret (nom, taux, assurance) VALUES (?, ?, ?)");
        $stmt->execute([$data->nom, $data->taux, $data->assurance]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE type_pret SET nom = ?, taux = ?, assurance = ? WHERE id = ?");
        $stmt->execute([$data->nom, $data->taux, $data->assurance, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM type_pret WHERE id = ?");
        $stmt->execute([$id]);
    }
}
