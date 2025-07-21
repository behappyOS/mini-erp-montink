<?php

class Produto {
    public static function all() {
        $db = Database::connect();
        return $db->query("SELECT * FROM produtos")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO produtos (nome, preco, estoque) VALUES (?, ?, ?)");
        $stmt->execute([
            $data['nome'],
            $data['preco'],
            $data['estoque']
        ]);
    }
}
