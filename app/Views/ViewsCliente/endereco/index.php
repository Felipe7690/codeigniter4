<?php
helper('functions');
session();
?>

<?= $this->extend('Templates_user') ?>
<?= $this->section('content') ?>

<div class="container">

    <h2 class="border-bottom border-2 border-primary mt-5 pt-3 mb-4"><?= esc($title ?? 'Meu Endereço') ?></h2>

    <?php if (session()->getFlashdata('msg')) : ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('msg') ?>
        </div>
    <?php endif; ?>

    <?php if ($cliente) : ?>
        <table class="table mt-4">
            <tbody>
                <tr>
                    <th scope="row" style="width: 150px;">Endereço:</th>
                    <td><?= esc($cliente->clientes_endereco) ?></td>
                </tr>
                <tr>
                    <th scope="row">Cidade:</th>
                    <td><?= esc($cidadeNome ?? 'Não informado') ?></td>
                </tr>
            </tbody>
        </table>
        <a href="<?= site_url('cliente/endereco/editar') ?>" class="btn btn-primary mt-3">Editar Endereço</a>
    <?php else : ?>
        <div class="alert alert-warning mt-4">Você ainda não cadastrou seu endereço.</div>
        <a href="<?= site_url('cliente/endereco/editar') ?>" class="btn btn-success mt-3">Cadastrar Endereço</a>
    <?php endif; ?>

</div>

<?= $this->endSection() ?>
