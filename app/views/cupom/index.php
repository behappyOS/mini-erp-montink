<?php include 'app/views/layout/header.php'; ?>

<div class="container py-4 text-light">
    <h2 class="mb-4">Gerenciar Cupons</h2>

    <form method="POST" action="/coupons/store" class="mb-4">
        <div class="mb-3">
            <label for="codigo" class="form-label">Código</label>
            <input type="text" id="codigo" name="codigo" class="form-control" placeholder="Código" required>
        </div>

        <div class="mb-3">
            <label for="valor" class="form-label">Valor de Desconto (%)</label>
            <input type="number" step="0.01" id="valor" name="valor" class="form-control" placeholder="Valor de desconto" required>
        </div>

        <div class="mb-3">
            <label for="minimo" class="form-label">Valor Mínimo</label>
            <input type="number" step="0.01" id="minimo" name="minimo" class="form-control" placeholder="Valor mínimo" required>
        </div>

        <div class="mb-3">
            <label for="validade" class="form-label">Validade</label>
            <input type="date" id="validade" name="validade" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Criar Cupom</button>
    </form>

    <h4>Cupons Existentes</h4>
    <ul class="list-group">
        <?php foreach ($coupons as $c): ?>
            <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                <div>
                    <strong><?= htmlspecialchars($c['codigo']) ?></strong> -
                    R$ <?= number_format($c['valor'], 2, ',', '.') ?>
                    (mín: R$ <?= number_format($c['minimo'], 2, ',', '.') ?>) -
                    até <?= date('d/m/Y', strtotime($c['validade'])) ?>
                </div>
                <form action="/coupons/delete" method="POST" onsubmit="return confirm('Deseja realmente excluir este cupom?');" class="mb-0">
                    <input type="hidden" name="id" value="<?= $c['id'] ?>">
                    <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include 'app/views/layout/footer.php'; ?>
