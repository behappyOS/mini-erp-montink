<?php

require_once '../app/models/Produto.php';

class ProdutoController extends Controller {
    public function index() {
        $produtos = Produto::all();
        $this->view('produto/index', ['produtos' => $produtos]);
    }

    public function store() {
        Produto::create($_POST);
        header('Location: ?c=produto&m=index');
    }
}
