<?php
require_once __DIR__ . '/../models/Pedido.php';
require_once __DIR__ . '/../models/Produto.php';

class PedidoController
{
    public function checkout()
    {
        $cep = $_POST['cep'] ?? '';
        $endereco = $_POST['endereco'] ?? '';
        $cidade = $_POST['cidade'] ?? '';
        $estado = $_POST['estado'] ?? '';

        $carrinho = $_SESSION['carrinho'] ?? [];
        $cupom = $_SESSION['cupom'] ?? null;

        if (empty($carrinho)) {
            header('Location: /carrinho');
            exit;
        }

        $produtoModel = new Produto();

        $subtotal = 0;
        foreach ($carrinho as $produtoId => $qtd) {
            $produto = $produtoModel->find($produtoId);
            if ($produto) {
                $subtotal += $produto['preco'] * $qtd;
            }
        }

        // Calcular frete
        $frete = 20.0;
        if ($subtotal >= 52.0 && $subtotal <= 166.59) {
            $frete = 15.0;
        } elseif ($subtotal > 200.0) {
            $frete = 0.0;
        }

        // Aplicar desconto do cupom se existir
        $desconto = 0.0;
        if ($cupom) {
            $desconto = $subtotal * ($cupom['desconto'] / 100);
        }

        $total = $subtotal + $frete - $desconto;

        // Salvar pedido
        $pedidoModel = new Pedido();
        $pedidoId = $pedidoModel->create([
            'subtotal' => $subtotal,
            'frete' => $frete,
            'desconto' => $desconto,
            'total' => $total,
            'cep' => $cep,
            'endereco' => $endereco,
            'cidade' => $cidade,
            'estado' => $estado,
            'status' => 'pendente',
        ]);

        // Assumindo método para salvar itens do pedido
        foreach ($carrinho as $produtoId => $qtd) {
            $pedidoModel->addItem($pedidoId, $produtoId, $qtd);
        }

        // Limpar sessão carrinho e cupom
        unset($_SESSION['carrinho']);
        unset($_SESSION['cupom']);

        // Redirecionar para página de confirmação
        header("Location: /pedido-finalizado?id={$pedidoId}");
    }

    public function finalizado()
    {
        $pedidoId = $_GET['id'] ?? null;
        if (!$pedidoId) {
            echo "Pedido não encontrado";
            exit;
        }
        require __DIR__ . '/../views/pedido/finalizar.php';
    }
}
