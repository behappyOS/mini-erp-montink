<?php include 'app/views/layout/header.php'; ?>

<h2>Carrinho de Compras</h2>

<?php if (empty($itens)): ?>
    <p>Seu carrinho está vazio.</p>
<?php else: ?>
    <table border="1" cellpadding="5">
        <thead>
        <tr>
            <th>Produto</th>
            <th>Preço Unitário</th>
            <th>Quantidade</th>
            <th>Subtotal</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php $total = 0; ?>
        <?php foreach ($itens as $item): ?>
            <?php $subtotal = $item['preco'] * $item['quantidade']; ?>
            <?php $total += $subtotal; ?>
            <tr>
                <td><?= $item['nome'] ?></td>
                <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                <td><?= $item['quantidade'] ?></td>
                <td>R$ <?= number_format($subtotal, 2, ',', '.') ?></td>
                <td>
                    <form action="/carrinho/remover" method="POST">
                        <input type="hidden" name="produto_id" value="<?= $item['id'] ?>">
                        <button type="submit">Remover</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <br>

    <!-- Aplicar cupom -->
    <form action="/carrinho/aplicar-cupom" method="POST">
        <label for="cupom">Cupom de Desconto:</label>
        <input type="text" name="codigo" id="cupom" placeholder="EX: DESCONTO10">
        <button type="submit">Aplicar</button>
    </form>

    <?php if (isset($cupom)): ?>
        <p><strong>Cupom aplicado:</strong> <?= $cupom['codigo'] ?> (<?= $cupom['desconto'] ?>% de desconto)</p>
        <?php $desconto = $total * ($cupom['desconto'] / 100); ?>
        <p><strong>Desconto:</strong> R$ <?= number_format($desconto, 2, ',', '.') ?></p>
        <p><strong>Total com Desconto:</strong> R$ <?= number_format($total - $desconto, 2, ',', '.') ?></p>
    <?php else: ?>
        <p><strong>Total:</strong> R$ <?= number_format($total, 2, ',', '.') ?></p>
    <?php endif; ?>

    <br>
    <form action="/pedido/finalizar" method="POST">
        <button type="submit">Finalizar Pedido</button>
    </form>
<?php endif; ?>

<?php include 'app/views/layout/footer.php'; ?>
