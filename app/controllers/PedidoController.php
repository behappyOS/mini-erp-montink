<?php
require_once __DIR__ . '/../models/Pedido.php';
require_once __DIR__ . '/../models/Produto.php';
require_once __DIR__ . '/../models/Estoque.php';
require_once 'app/helpers/EmailHelper.php';

class PedidoController
{
    public function checkout()
    {
        $cep = $_POST['cep'] ?? '';
        $endereco = $_POST['endereco'] ?? '';
        $email = $_POST['email'] ?? null;

        if (!$email) {
            die("Email é obrigatório para finalizar o pedido.");
        }

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

        $frete = 20.0;
        if ($subtotal >= 52.0 && $subtotal <= 166.59) {
            $frete = 15.0;
        } elseif ($subtotal > 200.0) {
            $frete = 0.0;
        }

        $desconto = 0.0;
        if ($cupom) {
            $desconto = $subtotal * ($cupom['desconto'] / 100);
        }

        $total = $subtotal + $frete - $desconto;

        $pedidoModel = new Pedido();
        $pedidoId = $pedidoModel->create([
            'email_cliente' => $email,
            'produtos' => json_encode($carrinho),
            'subtotal' => $subtotal,
            'frete' => $frete,
            'desconto' => $desconto,
            'total' => $total,
            'cep' => $cep,
            'endereco' => $endereco,
            'status' => 'pendente',
        ]);

        $estoqueModel = new Estoque();

        foreach ($carrinho as $produtoId => $qtd) {
            $estoqueAtual = $estoqueModel->findByProduto($produtoId);

            if ($estoqueAtual) {
                $novaQuantidade = $estoqueAtual['quantidade'] - $qtd;

                if ($novaQuantidade < 0) {
                    $novaQuantidade = 0;
                }

                $estoqueModel->updateByProduto($produtoId, $novaQuantidade);
            }
        }

        EmailHelper::enviarConfirmacaoPedido(
            $email,
            'Cliente',
            $pedidoId,
            number_format($total, 2, ',', '.'),
            $endereco,
            $cep
        );

        unset($_SESSION['carrinho']);
        unset($_SESSION['cupom']);

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

    public function webhook()
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!$data || !isset($data['pedido_id']) || !isset($data['status'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Dados inválidos: pedido_id e status são obrigatórios.']);
            return;
        }

        $pedidoId = (int)$data['pedido_id'];
        $status = $data['status'];

        require_once __DIR__ . '/../models/Pedido.php';
        $pedidoModel = new Pedido();

        try {
            if ($status === 'cancelado') {
                $pedidoModel->delete($pedidoId);
                $response = ['message' => "Pedido #$pedidoId removido com sucesso."];
            } else {
                $pedidoModel->updateStatus($pedidoId, $status);
                $response = ['message' => "Pedido #$pedidoId atualizado para status '$status'."];
            }

            header('Content-Type: application/json');
            echo json_encode($response);

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Erro interno: ' . $e->getMessage()]);
        }
    }

}
