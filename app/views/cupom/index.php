<?php include 'views/partials/header.php'; ?>
<div class="container">
    <h2>Gerenciar Cupons</h2>
    <form method="POST" action="/coupons/store">
        <input type="text" name="codigo" placeholder="Código" required>
        <input type="number" step="0.01" name="valor" placeholder="Valor de desconto" required>
        <input type="number" step="0.01" name="minimo" placeholder="Valor mínimo" required>
        <input type="date" name="validade" required>
        <button type="submit" class="btn btn-success">Criar Cupom</button>
    </form>

    <h4 class="mt-4">Cupons Existentes</h4>
    <ul>
        <?php foreach ($coupons as $c): ?>
            <li><?= $c['codigo'] ?> - R$<?= number_format($c['valor'], 2, ',', '.') ?> (min: R$<?= $c['minimo'] ?>) - até <?= date('d/m/Y', strtotime($c['validade'])) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php include 'views/partials/footer.php'; ?>
