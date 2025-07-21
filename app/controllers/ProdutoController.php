<?php
require_once __DIR__ . '/../models/Produto.php';
require_once __DIR__ . '/../models/Estoque.php';

class ProdutoController
{
    public function index()
    {
        $produtoModel = new Produto();
        $estoqueModel = new Estoque();

        $produtos = $produtoModel->all();

        foreach ($produtos as &$produto) {
            $estoque = $estoqueModel->findByProduto($produto['id']);
            $produto['quantidade'] = $estoque['quantidade'] ?? 0;
        }

        require __DIR__ . '/../views/produto/index.php';
    }

    public function create()
    {
        // Formulário para criar novo produto
        require __DIR__ . '/../views/produto/form.php';
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /produtos');
            exit;
        }

        $produtoModel = new Produto();
        $estoqueModel = new Estoque();

        $produto = $produtoModel->find($id);
        $estoque = $estoqueModel->findByProduto($id);

        if (!$produto) {
            header('Location: /produtos');
            exit;
        }

        $produto['quantidade'] = $estoque['quantidade'] ?? 0;

        require __DIR__ . '/../views/produto/form.php';
    }

    public function store()
    {
        $nome = $_POST['nome'] ?? '';
        $preco = $_POST['preco'] ?? 0;
        $quantidade = $_POST['estoque'] ?? 0;

        $produtoModel = new Produto();
        $estoqueModel = new Estoque();

        $idProduto = $produtoModel->create([
            'nome' => $nome,
            'preco' => $preco,
        ]);

        $estoqueModel->create($idProduto, $quantidade);

        header('Location: /produtos');
    }

    public function update()
    {
        $id = $_POST['id'] ?? null;
        $nome = $_POST['nome'] ?? '';
        $preco = $_POST['preco'] ?? 0;
        $quantidade = $_POST['quantidade'] ?? 0;

        if (!$id) {
            header('Location: /produtos');
            exit;
        }

        $produtoModel = new Produto();
        $estoqueModel = new Estoque();

        $produtoModel->update($id, [
            'nome' => $nome,
            'preco' => $preco,
        ]);

        $estoqueModel->updateByProduto($id, [
            'quantidade' => $quantidade,
        ]);

        header('Location: /produtos');
    }
}
