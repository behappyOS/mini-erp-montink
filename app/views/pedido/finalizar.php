<?php include 'app/views/layout/header.php'; ?>

<div class="container py-5 text-light text-center">
    <h2 class="mb-4">Pedido Finalizado</h2>

    <p class="fs-5">Obrigado pela sua compra!</p>
    <p class="fs-6">
        <strong>ID do pedido:</strong> <?= htmlspecialchars($_GET['id'] ?? 'N/A') ?>
    </p>

    <a href="/produtos" class="btn btn-primary mt-3">Voltar à Loja</a>
</div>

<?php include 'app/views/layout/footer.php'; ?>
