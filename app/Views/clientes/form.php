<?php
    helper('functions');
    session();
?>

<?= $this->extend('Templates_admin') ?>
<?= $this->section('content') ?>

<div class="container pt-4 pb-5 bg-light">
    <h2 class="border-bottom border-2 border-primary">
        <?= ucfirst($form).' '.$title ?>
    </h2>

    <form action="<?= base_url('clientes/update/'.$cliente->clientes_id); ?>" method="post">

        <!-- Nome -->
        <div class="mb-3">
            <label for="usuarios_nome" class="form-label">Nome</label>
            <input type="text" class="form-control" name="usuarios_nome" id="usuarios_nome" value="<?= esc($cliente->usuarios_nome) ?>">
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="usuarios_email" class="form-label">Email</label>
            <input type="email" class="form-control" name="usuarios_email" id="usuarios_email" value="<?= esc($cliente->usuarios_email) ?>">
        </div>

        <!-- Telefone -->
        <div class="mb-3">
            <label for="usuarios_fone" class="form-label">Telefone</label>
            <input type="tel" class="form-control" name="usuarios_fone" id="usuarios_fone" value="<?= esc($cliente->usuarios_fone) ?>">
        </div>

        <!-- Endereço -->
        <div class="mb-3">
            <label for="clientes_endereco" class="form-label">Endereço</label>
            <input type="text" class="form-control" name="clientes_endereco" id="clientes_endereco" value="<?= esc($cliente->clientes_endereco) ?>">
        </div>

        <!-- Campos ocultos -->
        <input type="hidden" name="clientes_id" value="<?= esc($cliente->clientes_id) ?>">
        <input type="hidden" name="clientes_usuarios_id" value="<?= esc($cliente->clientes_usuarios_id) ?>">

        <div class="mb-3">
            <button class="btn btn-success" type="submit">
                <?= ucfirst($form) ?> <i class="bi bi-floppy"></i>
            </button>
            <a href="<?= base_url('clientes'); ?>" class="btn btn-secondary ms-2">
                Cancelar <i class="bi bi-x-circle"></i>
            </a>
        </div>


    </form>
</div>

<?= $this->endSection() ?>
