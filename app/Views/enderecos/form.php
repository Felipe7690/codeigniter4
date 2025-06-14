<?php
helper('functions');
session();
?>

<?= $this->extend('Templates_admin') ?>
<?= $this->section('content') ?>

<div class="container pt-4 pb-5 bg-light">
    <h2 class="border-bottom border-2 border-primary">
        <?= ucfirst($form) . ' ' . $title ?>
    </h2>

    <form action="<?= base_url('clientes/salvarEndereco/' . $cliente->clientes_id); ?>" method="post">

        <div class="mb-3">
            <label for="clientes_endereco" class="form-label">Endereço</label>
            <input type="text" class="form-control" id="clientes_endereco" name="clientes_endereco" value="<?= esc($cliente->clientes_endereco) ?>" required>
        </div>

        <div class="mb-3">
            <label for="clientes_cidade_id" class="form-label">Cidade</label>
            <select class="form-select" id="clientes_cidade_id" name="clientes_cidade_id" required>
                <option value="">Selecione a cidade</option>
                <?php foreach ($cidades as $cidade): ?>
                    <option value="<?= $cidade->cidades_id ?>" <?= ($cliente->clientes_cidade_id == $cidade->cidades_id) ? 'selected' : '' ?>>
                        <?= esc($cidade->cidades_nome) ?> - <?= esc($cidade->cidades_uf) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <input type="hidden" name="clientes_id" value="<?= esc($cliente->clientes_id) ?>">
        <input type="hidden" name="clientes_usuarios_id" value="<?= esc($cliente->clientes_usuarios_id) ?>">

        <div class="mb-3">
            <button type="submit" class="btn btn-success">
                <?= ucfirst($form) ?> <i class="bi bi-floppy"></i>
            </button>
            <a href="<?= base_url('enderecos') ?>" class="btn btn-secondary ms-2">
                Cancelar <i class="bi bi-x-circle"></i>
            </a>
        </div>

    </form>
</div>

<?= $this->endSection() ?>
