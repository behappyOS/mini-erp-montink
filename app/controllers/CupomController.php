<?php

require_once 'app/models/Cupom.php';

class CupomController
{
    public function index()
    {
        $cupomModel = new Cupom();
        $coupons = $cupomModel->all();

        require 'app/views/cupom/index.php';
    }

    public function store()
    {
        $codigo = $_POST['codigo'] ?? '';
        $desconto = $_POST['valor'] ?? 0;
        $minimo = $_POST['minimo'] ?? 0;
        $validade = $_POST['validade'] ?? null;

        if (!$codigo || !$validade) {
            $_SESSION['error'] = "Código e validade são obrigatórios.";
            header('Location: /coupons');
            exit;
        }

        $cupomModel = new Cupom();

        $success = $cupomModel->create([
            'codigo' => $codigo,
            'desconto' => $desconto,
            'minimo' => $minimo,
            'validade' => $validade,
            'ativo' => 1
        ]);

        if ($success) {
            $_SESSION['success'] = "Cupom criado com sucesso!";
        } else {
            $_SESSION['error'] = "Erro ao criar cupom. Código pode já existir.";
        }

        header('Location: /coupons');
        exit;
    }

    public function delete()
    {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $cupomModel = new Cupom();
            $cupomModel->delete($id);
            $_SESSION['success'] = "Cupom removido com sucesso.";
        }
        header('Location: /coupons');
        exit;
    }

    public function validar()
    {
        $codigo = $_POST['codigo'] ?? '';
        $subtotal = $_POST['subtotal'] ?? 0;

        $cupomModel = new Cupom();
        $resultado = $cupomModel->validar($codigo, $subtotal);

        header('Content-Type: application/json');
        echo json_encode($resultado);
        exit;
    }
}
