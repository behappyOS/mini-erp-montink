<?php

require_once 'app/core/Model.php';

class Pedido extends Model
{
    protected $table = 'pedidos';

    public function create($dados)
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (email_cliente, produtos, total, cep, endereco, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $dados['email_cliente'],
            json_encode($dados['produtos']),
            $dados['total'],
            $dados['cep'],
            $dados['endereco'],
            $dados['status'] ?? 'pendente'
        ]);

        return $this->pdo->lastInsertId();
    }

    public function updateStatus($id, $status)
    {
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
