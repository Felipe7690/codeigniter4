<?php
helper('functions');
session();
?>

<?= $this->extend('Templates_admin') ?>
<?= $this->section('content') ?>

<div class="container">

    <h2 class="border-bottom border-2 border-primary mt-5 pt-3 mb-4"> <?= $title ?> </h2>

    <?php if (isset($msg)) { 
        echo $msg; 
    } ?>

    <form action="<?= base_url('clientes/search'); ?>" class="d-flex" role="search" method="post">
        <input 
            class="form-control me-2" 
            name="pesquisar" 
            type="search" 
            placeholder="Pesquisar" 
            aria-label="Search"
        >
        <button class="btn btn-outline-success" type="submit">
            <i class="bi bi-search"></i>
        </button>
    </form>

    <table class="table mt-4">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Telefone</th>
                <th scope="col">Endereço</th>
                <th scope="col">
                    <a class="btn btn-success" href="<?= base_url('clientes/create'); ?>">
                        Novo
                        <i class="bi bi-plus-circle"></i>
                    </a>
                </th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <th scope="row"><?= esc($cliente->clientes_id) ?></th>
                    <td><?= esc($cliente->usuarios_nome) ?></td>
                    <td><?= esc($cliente->usuarios_email) ?></td>
                    <td><?= esc($cliente->usuarios_fone) ?></td>
                    <td><?= esc($cliente->clientes_endereco) ?></td>
                    <td>
                        <a class="btn btn-primary" href="<?= base_url('clientes/edit/' . $cliente->clientes_id); ?>">
                            Editar
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form 
                            action="<?= base_url('clientes/delete/' . $cliente->clientes_id); ?>" 
                            method="post" 
                            style="display:inline;" 
                            onsubmit="return confirm('Confirma a exclusão deste cliente?')"
                        >
                            <button type="submit" class="btn btn-danger">
                                Excluir
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<?= $this->endSection() ?>
