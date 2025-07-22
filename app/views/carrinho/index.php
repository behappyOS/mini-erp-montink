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

        <?php
        $desconto = 0;
        if (isset($cupom)) {
            $desconto = $total * ($cupom['desconto'] / 100);
        }
        $subtotal_com_desconto = $total - $desconto;

        // Cálculo do frete baseado no subtotal com desconto
        if ($subtotal_com_desconto >= 52 && $subtotal_com_desconto <= 166.59) {
            $frete = 15.00;
        } elseif ($subtotal_com_desconto > 200) {
            $frete = 0.00;
        } else {
            $frete = 20.00;
        }

        $total_final = $subtotal_com_desconto + $frete;
        ?>

        <p><strong>Subtotal:</strong> R$ <?= number_format($total, 2, ',', '.') ?></p>
        <?php if (isset($cupom)): ?>
            <p><strong>Cupom aplicado:</strong> <?= htmlspecialchars($cupom['codigo']) ?> (<?= $cupom['desconto'] ?>% de desconto)</p>
            <p><strong>Desconto:</strong> R$ <?= number_format($desconto, 2, ',', '.') ?></p>
            <p><strong>Subtotal com desconto:</strong> R$ <?= number_format($subtotal_com_desconto, 2, ',', '.') ?></p>
        <?php endif; ?>
        <p><strong>Frete:</strong> R$ <?= number_format($frete, 2, ',', '.') ?></p>
        <p><strong>Total a pagar:</strong> R$ <?= number_format($total_final, 2, ',', '.') ?></p>

        <hr>

        <!-- CEP -->
        <div class="mb-4">
            <label for="cep" class="form-label">Informe seu CEP para calcular o frete e endereço:</label>
            <div class="input-group" style="max-width: 300px;">
                <input type="text" id="cep" class="form-control" placeholder="Ex: 01001000" maxlength="8" pattern="\d{8}" required>
                <button class="btn btn-secondary" id="btnBuscarCep">Buscar</button>
            </div>
            <div id="endereco" class="mt-2"></div>
            <div id="erroCep" class="text-danger mt-2"></div>
        </div>

        <form action="/pedido/finalizar" method="POST">
            <input type="hidden" name="frete" value="<?= $frete ?>">
            <input type="hidden" name="cupom_codigo" value="<?= htmlspecialchars($cupom['codigo'] ?? '') ?>">

            <div class="mb-3" style="max-width: 400px;">
                <label for="email" class="form-label">Seu e-mail:</label>
                <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        placeholder="seu@email.com"
                        required
                >
            </div>
            
            <button type="submit" class="btn btn-success btn-lg mt-3">Finalizar Pedido</button>
        </form>
    <?php endif; ?>
</div>

<script>
    document.getElementById('btnBuscarCep').addEventListener('click', function(e) {
        e.preventDefault();
        const cep = document.getElementById('cep').value.trim();

        const erroCep = document.getElementById('erroCep');
        const enderecoDiv = document.getElementById('endereco');

        erroCep.textContent = '';
        enderecoDiv.textContent = '';

        // Validação simples do CEP (8 dígitos numéricos)
        if (!/^\d{8}$/.test(cep)) {
            erroCep.textContent = 'Por favor, informe um CEP válido com 8 números.';
            return;
        }

        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (data.erro) {
                    erroCep.textContent = 'CEP não encontrado.';
                    return;
                }

                enderecoDiv.innerHTML = `
                    <strong>Endereço encontrado:</strong><br>
                    ${data.logradouro}, ${data.bairro}<br>
                    ${data.localidade} - ${data.uf}
                `;
            })
            .catch(() => {
                erroCep.textContent = 'Erro ao consultar o CEP. Tente novamente.';
            });
    });
</script>

<?php include 'app/views/layout/footer.php'; ?>
