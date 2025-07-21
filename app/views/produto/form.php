<?php include '../app/views/layout/header.php'; ?>

<h2>Cadastro de Produtos</h2>

<form method="post" action="?c=produto&m=store">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome do Produto</label>
        <input type="text" class="form-control" name="nome" required>
    </div>
    <div class="mb-3">
        <label for="preco" class="form-label">Preço</label>
        <input type="number" step="0.01" class="form-control" name="preco" required>
    </div>
    <div class="mb-3">
        <label for="estoque" class="form-label">Estoque</label>
        <input type="number" class="form-control" name="estoque" required>
    </div>
    <button type="submit" class="btn btn-primary">Salvar Produto</button>
</form>

<hr>

<h3>Produtos Cadastrados</h3>
<table class="table table-bordered">
    <thead>
    <tr>
        <th>Nome</th>
        <th>Preço</th>
        <th>Estoque</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($produtos as $produto): ?>
        <tr>
            <td><?= $produto['nome'] ?></td>
            <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
            <td><?= $produto['estoque'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php include '../app/views/layout/footer.php'; ?>
