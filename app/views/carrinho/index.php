<?php include 'app/views/layout/header.php'; ?>

<div class="container py-4 text-light">
    <h2 class="mb-4">Carrinho de Compras</h2>

    <?php if (empty($itens)): ?>
        <p>Seu carrinho está vazio.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-dark table-striped align-middle">
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
                        <td><?= htmlspecialchars($item['nome']) ?></td>
                        <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                        <td><?= $item['quantidade'] ?></td>
                        <td>R$ <?= number_format($subtotal, 2, ',', '.') ?></td>
                        <td>
                            <form action="/carrinho/remover" method="POST" class="d-inline">
                                <input type="hidden" name="produto_id" value="<?= $item['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Remover</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="my-4">
            <form action="/carrinho/aplicar-cupom" method="POST" class="row g-2 align-items-center">
                <div class="col-auto">
                    <label for="cupom" class="col-form-label">Cupom de Desconto:</label>
                </div>
                <div class="col-auto">
                    <input
                            type="text"
                            name="codigo"
                            id="cupom"
                            placeholder="EX: DESCONTO10"
                            class="form-control"
                    >
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Aplicar</button>
                </div>
            </form>
        </div>

        <?php if (isset($cupom)): ?>
            <?php
            $desconto = $total * ($cupom['desconto'] / 100);
            $total_com_desconto = $total - $desconto;
            ?>
            <p><strong>Cupom aplicado:</strong> <?= htmlspecialchars($cupom['codigo']) ?> (<?= $cupom['desconto'] ?>% de desconto)</p>
            <p><strong>Desconto:</strong> R$ <?= number_format($desconto, 2, ',', '.') ?></p>
            <p><strong>Total com Desconto:</strong> R$ <?= number_format($total_com_desconto, 2, ',', '.') ?></p>
        <?php else: ?>
            <p><strong>Total:</strong> R$ <?= number_format($total, 2, ',', '.') ?></p>
        <?php endif; ?>

        <form action="/pedido/finalizar" method="POST">
            <button type="submit" class="btn btn-success btn-lg mt-3">Finalizar Pedido</button>
        </form>
    <?php endif; ?>
</div>

<?php include 'app/views/layout/footer.php'; ?>
