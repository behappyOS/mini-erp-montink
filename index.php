<?php
// Iniciar sessão para carrinho e cupons
session_start();

// Carregar roteador
require_once __DIR__ . '/app/core/Router.php';

$router = new Router();

// Registrar rotas GET
$router->get('/produtos', 'ProdutoController@index');
$router->get('/produtos/novo', 'ProdutoController@create');
$router->get('/produtos/editar', 'ProdutoController@edit');
$router->get('/carrinho', 'CarrinhoController@index');
$router->get('/pedido-finalizado', 'PedidoController@finalizado');

// Registrar rotas POST
$router->post('/produtos/salvar', 'ProdutoController@store');
$router->post('/produtos/atualizar', 'ProdutoController@update');
$router->post('/carrinho/adicionar', 'CarrinhoController@adicionar');
$router->post('/carrinho/remover', 'CarrinhoController@remover');
$router->post('/carrinho/aplicar-cupom', 'CarrinhoController@aplicarCupom');
$router->post('/pedido/finalizar', 'PedidoController@checkout');

// Disparar rota atual
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
