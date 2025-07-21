<?php include 'app/views/layout/header.php'; ?>

<h2 class="mb-4"><?= isset($produto) ? 'Editar' : 'Cadastrar' ?> Produto</h2>

<form action="<?= isset($produto) ? '/produtos/atualizar' : '/produtos/salvar' ?>" method="POST" class="needs-validation" novalidate>
    <?php if (isset($produto)): ?>
        <input type="hidden" name="id" value="<?= htmlspecialchars($produto['id']) ?>">
    <?php endif; ?>

    <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input
                type="text"
                class="form-control"
                id="nome"
                name="nome"
                value="<?= htmlspecialchars($produto['nome'] ?? '') ?>"
                required
        >
        <div class="invalid-feedback">
            Por favor, insira o nome do produto.
        </div>
    </div>

    <div class="mb-3">
        <label for="preco" class="form-label">Preço (R$)</label>
        <input
                type="number"
                step="0.01"
                class="form-control"
                id="preco"
                name="preco"
                value="<?= htmlspecialchars($produto['preco'] ?? '') ?>"
                required
        >
        <div class="invalid-feedback">
            Por favor, insira o preço do produto.
        </div>
    </div>

    <div class="mb-3">
        <label for="estoque" class="form-label">Estoque</label>
        <input
                type="number"
                class="form-control"
                id="estoque"
                name="estoque"
                value="<?= htmlspecialchars($produto['quantidade'] ?? '') ?>"
                min="0"
                required
        >
        <div class="invalid-feedback">
            Por favor, insira a quantidade em estoque.
        </div>
    </div>

    <button type="submit" class="btn btn-primary">
        <?= isset($produto) ? 'Atualizar' : 'Salvar' ?>
    </button>
    <a href="/produtos" class="btn btn-secondary ms-2">Cancelar</a>
</form>

<script>
    (() => {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })();
</script>

<?php include 'app/views/layout/footer.php'; ?>
