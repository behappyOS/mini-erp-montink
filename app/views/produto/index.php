<?php include 'app/views/layout/header.php'; ?>

<h2 class="mb-4">Lista de Produtos</h2>

<table class="table table-dark table-striped table-hover align-middle">
    <thead>
    <tr>
        <th>Nome</th>
        <th>Preço</th>
        <th>Estoque</th>
        <th>Editar</th>
        <th>Comprar</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($produtos as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['nome']) ?></td>
            <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
            <td><?= $p['quantidade'] ?? 0 ?></td>
            <td>
                <a href="/produtos/editar?id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
            </td>
            <td>
                <form action="/carrinho/adicionar" method="POST" class="d-flex gap-2 align-items-center">
                    <input type="hidden" name="produto_id" value="<?= $p['id'] ?>">
                    <input
                        type="number"
                        name="quantidade"
                        value="1"
                        min="1"
                        max="<?= $p['quantidade'] ?? 1 ?>"
                        class="form-control form-control-sm"
                        style="max-width: 80px;"
                    >
                    <button type="submit" class="btn btn-primary btn-sm">Adicionar</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php include 'app/views/layout/footer.php'; ?>
