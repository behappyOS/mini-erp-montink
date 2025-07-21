<?php include 'app/views/layout/header.php'; ?>

<h2>Lista de Produtos</h2>

<a href="/produtos/novo">Novo Produto</a>
<table border="1" cellpadding="5">
    <thead>
    <tr>
        <th>Nome</th>
        <th>Preço</th>
        <th>Estoque</th>
        <th>Comprar</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($produtos as $p): ?>
        <tr>
            <td><?= $p['nome'] ?></td>
            <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
            <td><?= $p['quantidade'] ?? 0 ?></td>
            <td>
                <form action="/carrinho/adicionar" method="POST">
                    <input type="hidden" name="produto_id" value="<?= $p['id'] ?>">
                    <input type="number" name="quantidade" value="1" min="1" max="<?= $p['quantidade'] ?? 1 ?>">
                    <button type="submit">Adicionar</button>
                </form>
            </td>
            <td>
                <a href="/produtos/editar?id=<?= $p['id'] ?>">Editar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php include 'app/views/layout/footer.php'; ?>
