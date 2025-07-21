<?php
class Cupom {
    public function all() {
        $db = Database::getInstance()->getConnection();
        return $db->query("SELECT * FROM cupons")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO cupons (codigo, valor, minimo, validade) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $data['codigo'], $data['valor'], $data['minimo'], $data['validade']
        ]);
    }

    public function findByCode($code) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM cupons WHERE codigo = ?");
        $stmt->execute([$code]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
