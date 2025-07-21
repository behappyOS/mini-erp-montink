<?php
require_once __DIR__ . '/../models/Produto.php';
require_once __DIR__ . '/../models/Cupom.php';

class CarrinhoController
{
    public function index()
    {
        $produtoModel = new Produto();

        $carrinho = $_SESSION['carrinho'] ?? [];
        $cupom = $_SESSION['cupom'] ?? null;

        $itens = [];
        foreach ($carrinho as $produtoId => $quantidade) {
            $produto = $produtoModel->find($produtoId);
            if ($produto) {
                $produto['quantidade'] = $quantidade;
                $itens[] = $produto;
            }
        }

        require __DIR__ . '/../views/carrinho/index.php';
    }

    public function adicionar()
    {
        $produtoId = $_POST['produto_id'] ?? null;
        $quantidade = intval($_POST['quantidade'] ?? 1);

        if (!$produtoId || $quantidade < 1) {
            header('Location: /produtos');
            exit;
        }

        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        if (!isset($_SESSION['carrinho'][$produtoId])) {
            $_SESSION['carrinho'][$produtoId] = 0;
        }

        $_SESSION['carrinho'][$produtoId] += $quantidade;

        header('Location: /carrinho');
    }

    public function remover()
    {
        $produtoId = $_POST['produto_id'] ?? null;

        if ($produtoId && isset($_SESSION['carrinho'][$produtoId])) {
            unset($_SESSION['carrinho'][$produtoId]);
        }

        header('Location: /carrinho');
    }

    public function aplicarCupom()
    {
        $codigo = trim($_POST['codigo'] ?? '');

        if (empty($codigo)) {
            $_SESSION['cupom'] = null;
            header('Location: /carrinho');
            exit;
        }

        $cupomModel = new Cupom();
        $cupom = $cupomModel->findByCodigo($codigo);

        $subtotal = 0;
        if (isset($_SESSION['carrinho'])) {
            $produtoModel = new Produto();
            foreach ($_SESSION['carrinho'] as $produtoId => $qtd) {
                $produto = $produtoModel->find($produtoId);
                if ($produto) {
                    $subtotal += $produto['preco'] * $qtd;
                }
            }
        }

        if ($cupom &&
            $cupomModel->isValido($cupom) &&
            $subtotal >= $cupom['valor_minimo']) {
            $_SESSION['cupom'] = $cupom;
        } else {
            $_SESSION['cupom'] = null;
        }

        header('Location: /carrinho');
    }
}
