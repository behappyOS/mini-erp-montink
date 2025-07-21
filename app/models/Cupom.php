<?php

require_once 'app/core/Model.php';

class Cupom extends Model
{
    protected $table = 'cupons';

    public function findByCodigo($codigo)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE codigo = ?");
        $stmt->execute([$codigo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function isValido($cupom)
    {
        $hoje = date('Y-m-d');
        return $cupom && $cupom['validade'] >= $hoje;
    }
}
