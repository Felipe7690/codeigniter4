<?= $this->extend('Templates_user') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <h3><?= $cliente ? 'Editar' : 'Cadastrar' ?> Endereço</h3>

    <form action="<?= site_url('cliente/endereco/salvar') ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="clientes_endereco" class="form-label">Endereço</label>
            <input type="text" id="clientes_endereco" name="clientes_endereco" class="form-control"
                   value="<?= esc($cliente->clientes_endereco ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label for="clientes_cidade_id" class="form-label">Cidade</label>
            <select id="clientes_cidade_id" name="clientes_cidade_id" class="form-select" required>
                <option value="">Selecione a cidade</option>
                <?php foreach ($cidades as $cidade): ?>
                    <option value="<?= $cidade->cidades_id ?>"
                        <?= isset($cliente->clientes_cidade_id) && $cliente->clientes_cidade_id == $cidade->cidades_id ? 'selected' : '' ?>>
                        <?= esc($cidade->cidades_nome) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="<?= site_url('cliente/endereco') ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?= $this->endSection() ?>
