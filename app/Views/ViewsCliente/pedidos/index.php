<?php
helper('functions');
session();
?>

<?= $this->extend('Templates_user') ?>
<?= $this->section('content') ?>

<div class="container">

    <h2 class="border-bottom border-2 border-primary mt-5 pt-3 mb-4"><?= esc($title) ?></h2>

    <?php if (isset($msg)) echo $msg; ?>

    <?php if (!empty($pedidos)) : ?>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th scope="col">ID Pedido</th>
                    <th scope="col">Produto</th>
                    <th scope="col">Data</th>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Preço Unitário</th>
                    <th scope="col">Total</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <th scope="row"><?= esc($pedido->pedidos_id) ?></th>
                        <td><?= esc($pedido->produtos_nome) ?></td>
                        <td><?= esc(date('d/m/Y H:i', strtotime($pedido->vendas_data))) ?></td>
                        <td><?= esc($pedido->pedidos_quantidade) ?></td>
                        <td>R$ <?= number_format($pedido->pedidos_preco_unitario, 2, ',', '.') ?></td>
                        <td>R$ <?= number_format($pedido->pedidos_preco_unitario * $pedido->pedidos_quantidade, 2, ',', '.') ?></td>
                        <td><?= esc(ucfirst($pedido->vendas_status)) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning mt-4">Você ainda não fez nenhum pedido.</div>
    <?php endif; ?>

</div>

<?= $this->endSection() ?>
