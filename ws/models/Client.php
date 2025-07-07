<?php
require_once __DIR__ . '/../db.php';

class Client {

    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM client");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function insert($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO client (nom, email) VALUES (?, ?)");
        $stmt->execute([$data->nom, $data->email]);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM client WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE client SET nom = ?, email = ? WHERE id = ?");
        $stmt->execute([$data->nom, $data->email, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM client WHERE id = ?");
        $stmt->execute([$id]);
    }
}
