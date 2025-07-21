<?php

require_once 'app/core/Model.php';

class Estoque extends Model
{
    protected $table = 'estoques';

    public function findByProduto($produtoId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE produto_id = ?");
        $stmt->execute([$produtoId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($produtoId, $quantidade)
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (produto_id, quantidade) VALUES (?, ?)");
        return $stmt->execute([$produtoId, $quantidade]);
    }

    public function updateByProduto($produtoId, $quantidade)
    {
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET quantidade = ? WHERE produto_id = ?");
        return $stmt->execute([$quantidade, $produtoId]);
    }
}
