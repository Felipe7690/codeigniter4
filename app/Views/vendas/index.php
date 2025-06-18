<?= $this->extend('Templates_admin') ?>
<?= $this->section('content') ?>

<div class="container">
    <h2 class="border-bottom border-2 border-primary mt-3 mb-4"><?= esc($title ?? 'Lista de Vendas') ?></h2>
    
    <?php if(!empty($msg)){echo $msg;} ?>

    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Data</th>
                <th>Total</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vendas as $venda): ?>
            <tr>
                <td><?= $venda->vendas_id ?></td>
                <td><?= esc($venda->cliente_nome) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($venda->vendas_data)) ?></td>
                <td>R$ <?= moedaReal($venda->vendas_total) ?></td>
                <td><span class="badge bg-primary"><?= esc($venda->vendas_status) ?></span></td>
                <td>
                    <?php if ($venda->vendas_status == 'Aberta'): ?>
                        <a class="btn btn-success btn-sm" href="<?= base_url('vendas/realizar/' . $venda->vendas_id) ?>" onclick="return confirm('Confirmar esta venda como realizada?');">
                            <i class="bi bi-check-lg"></i> Realizar
                        </a>
                    <?php endif; ?>

                    <a class="btn btn-secondary btn-sm" href="<?= base_url('vendas/edit/' . $venda->vendas_id) ?>">
                        <i class="bi bi-pencil-square"></i> Editar
                    </a>
                    <a class="btn btn-danger btn-sm" href="<?= base_url('vendas/delete/' . $venda->vendas_id) ?>" onclick="return confirm('Tem certeza?');">
                        <i class="bi bi-x-circle"></i> Excluir
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>