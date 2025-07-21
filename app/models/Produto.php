<?php

require_once 'app/core/Model.php';

class Produto extends Model
{
    protected $table = 'produtos';

    public function all()
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (nome, preco) VALUES (?, ?)");
        $stmt->execute([$data['nome'], $data['preco']]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET nome = ?, preco = ? WHERE id = ?");
        return $stmt->execute([$data['nome'], $data['preco'], $id]);
    }
}
