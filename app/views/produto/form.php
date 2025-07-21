<?php include 'app/views/layout/header.php'; ?>

<h2><?= isset($produto) ? 'Editar' : 'Cadastrar' ?> Produto</h2>

<form action="<?= isset($produto) ? '/produtos/atualizar' : '/produtos/salvar' ?>" method="POST">
    <?php if (isset($produto)): ?>
        <input type="hidden" name="id" value="<?= $produto['id'] ?>">
    <?php endif; ?>

    <label>Nome:</label><br>
    <input type="text" name="nome" value="<?= $produto['nome'] ?? '' ?>" required><br><br>

    <label>Preço:</label><br>
    <input type="number" step="0.01" name="preco" value="<?= $produto['preco'] ?? '' ?>" required><br><br>

    <label>Estoque:</label><br>
    <input type="number" name="estoque" value="<?= $produto['quantidade'] ?? '' ?>" required><br><br>

    <button type="submit"><?= isset($produto) ? 'Atualizar' : 'Salvar' ?></button>
</form>

<?php include 'app/views/layout/footer.php'; ?>
