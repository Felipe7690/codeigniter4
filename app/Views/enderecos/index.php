<?php
helper('functions');
session();
?>

<?= $this->extend('Templates_admin') ?>
<?= $this->section('content') ?>

<div class="container">

    <h2 class="border-bottom border-2 border-primary mt-5 pt-3 mb-4"><?= esc($title) ?></h2>

    <?php if(session()->getFlashdata('msg')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('msg') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('clientes/searchEndereco'); ?>" method="post" class="d-flex mb-3" role="search">
        <input
            class="form-control me-2"
            name="pesquisarEndereco"
            type="search"
            placeholder="Pesquisar cliente pelo endereço"
            aria-label="Pesquisar"
            value="<?= isset($pesquisarEndereco) ? esc($pesquisarEndereco) : '' ?>"
            required
        >
        <button class="btn btn-outline-success" type="submit">
            <i class="bi bi-search"></i>
        </button>
    </form>

    <table class="table mt-2">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Cliente</th>
                <th scope="col">Endereço</th>
                <th scope="col">Cidade</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">

            <?php if (!empty($clientes)): ?>
                <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <th scope="row"><?= esc($cliente->clientes_id) ?></th>
                        <td><?= esc($cliente->usuarios_nome) ?></td>
                        <td><?= esc($cliente->clientes_endereco) ?></td>
                        <td><?= esc($cliente->cidades_nome ?? '---') ?></td>
                        <td>
                            <a class="btn btn-primary" href="<?= base_url('clientes/editarEndereco/' . $cliente->clientes_id); ?>">
                                Editar
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">
                        <?= isset($msg) ? esc($msg) : 'Nenhum endereço encontrado.' ?>
                    </td>
                </tr>
            <?php endif; ?>

        </tbody>
    </table>

</div>

<?= $this->endSection() ?>
