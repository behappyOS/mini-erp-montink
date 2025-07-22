<?php

require_once 'app/core/Model.php';

class Cupom extends Model
{
    protected $table = 'cupons';

    public function all()
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} ORDER BY criado_em DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByCodigo($codigo)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE codigo = ?");
        $stmt->execute([$codigo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (codigo, desconto, minimo, validade, ativo) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['codigo'],
            $data['desconto'],
            $data['minimo'],
            $data['validade'],
            $data['ativo'] ?? 1
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function validar($codigo, $subtotal)
    {
        $cupom = $this->findByCodigo($codigo);

        if (!$cupom) {
            return ['valido' => false, 'mensagem' => 'Cupom não encontrado.'];
        }

        if (!$cupom['ativo']) {
            return ['valido' => false, 'mensagem' => 'Cupom está inativo.'];
        }

        $hoje = date('Y-m-d');
        if ($cupom['validade'] < $hoje) {
            return ['valido' => false, 'mensagem' => 'Cupom expirado.'];
        }

        if ($subtotal < $cupom['minimo']) {
            return ['valido' => false, 'mensagem' => "Subtotal mínimo de R$ ".number_format($cupom['minimo'], 2, ',', '.')." não atingido."];
        }

        return [
            'valido' => true,
            'desconto' => $cupom['desconto'],
            'codigo' => $cupom['codigo'],
            'mensagem' => 'Cupom válido!'
        ];
    }

    public function isValido($cupom)
    {
        if (!$cupom) {
            return false;
        }

        if (!$cupom['ativo']) {
            return false;
        }

        $hoje = date('Y-m-d');
        if ($cupom['validade'] < $hoje) {
            return false;
        }

        return true;
    }
}
