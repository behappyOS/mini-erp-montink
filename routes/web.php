<?php

$router->get('/produtos', 'ProdutoController@index');
$router->get('/produtos/novo', 'ProdutoController@create');
$router->get('/produtos/editar', 'ProdutoController@edit');
$router->get('/carrinho', 'CarrinhoController@index');
$router->get('/pedido-finalizado', 'PedidoController@finalizado');
$router->get('/coupons', 'CupomController@index');

$router->post('/coupons/store', 'CupomController@store');
$router->post('/coupons/delete', 'CupomController@delete');
$router->post('/coupons/validar', 'CupomController@validar');
$router->post('/produtos/salvar', 'ProdutoController@store');
$router->post('/produtos/atualizar', 'ProdutoController@update');
$router->post('/carrinho/adicionar', 'CarrinhoController@adicionar');
$router->post('/carrinho/remover', 'CarrinhoController@remover');
$router->post('/carrinho/aplicar-cupom', 'CarrinhoController@aplicarCupom');
$router->post('/pedido/finalizar', 'PedidoController@checkout');
$router->post('/pedido/webhook', 'PedidoController@webhook');
