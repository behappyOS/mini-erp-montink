<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mini ERP - Produtos</title>
    <!-- Bootstrap CSS (Dark theme via CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #121212;
            color: #fff;
        }
        table {
            color: #fff;
        }
        a, a:hover {
            color: #0d6efd;
        }
        .btn-custom {
            background-color: #0d6efd;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0b5ed7;
            color: white;
        }
        input[type=number] {
            max-width: 80px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="/">Mini ERP</a>
        <div>
            <a href="/produtos/novo" class="btn btn-outline-light">Novo Produto</a>
            <a href="/coupons" class="btn btn-info">Gerenciar Cupons</a>
        </div>
    </div>
</nav>
<div class="container">
