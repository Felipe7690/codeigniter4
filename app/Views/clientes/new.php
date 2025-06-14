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

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('clientes/store'); ?>" method="post">
        <?= csrf_field() ?>

        <!-- Usuário -->
        <div class="mb-3">
            <label for="clientes_usuarios_id" class="form-label">Usuário</label>
            <select name="clientes_usuarios_id" id="clientes_usuarios_id" class="form-select <?= isset($validation) && $validation->hasError('clientes_usuarios_id') ? 'is-invalid' : '' ?>" required>
                <option value="">Selecione o usuário</option>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= esc($usuario->usuarios_id) ?>" <?= set_select('clientes_usuarios_id', $usuario->usuarios_id) ?>>
                        <?= esc($usuario->usuarios_nome) ?> - <?= esc($usuario->usuarios_email) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if(isset($validation) && $validation->hasError('clientes_usuarios_id')): ?>
                <div class="invalid-feedback">
                    <?= $validation->getError('clientes_usuarios_id') ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Endereço -->
        <div class="mb-3">
            <label for="clientes_endereco" class="form-label">Endereço</label>
            <input type="text" class="form-control <?= isset($validation) && $validation->hasError('clientes_endereco') ? 'is-invalid' : '' ?>" 
                   name="clientes_endereco" id="clientes_endereco" value="<?= set_value('clientes_endereco') ?>" required>
            <?php if(isset($validation) && $validation->hasError('clientes_endereco')): ?>
                <div class="invalid-feedback">
                    <?= $validation->getError('clientes_endereco') ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Cidade -->
        <div class="mb-3">
            <label for="clientes_cidade_id" class="form-label">Cidade</label>
            <select name="clientes_cidade_id" id="clientes_cidade_id" class="form-select <?= isset($validation) && $validation->hasError('clientes_cidade_id') ? 'is-invalid' : '' ?>" required>
                <option value="">Selecione a cidade</option>
                <?php foreach ($cidades as $cidade): ?>
                    <option value="<?= esc($cidade->cidades_id) ?>" <?= set_select('clientes_cidade_id', $cidade->cidades_id) ?>>
                        <?= esc($cidade->cidades_nome) ?> - <?= esc($cidade->cidades_uf) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if(isset($validation) && $validation->hasError('clientes_cidade_id')): ?>
                <div class="invalid-feedback">
                    <?= $validation->getError('clientes_cidade_id') ?>
                </div>
            <?php endif; ?>
        </div>

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
