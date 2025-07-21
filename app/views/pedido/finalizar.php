<?php include 'app/views/layout/header.php'; ?>

<h2>Pedido Finalizado</h2>

<p>Obrigado pela sua compra!</p>
<p>ID do pedido: <?= $_GET['id'] ?? 'N/A' ?></p>

<a href="/produtos">Voltar à Loja</a>

<?php include 'app/views/layout/footer.php'; ?>
