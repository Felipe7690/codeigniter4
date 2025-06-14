<?php
helper('functions');
session();
if (isset($_SESSION['login'])) {
    $login = $_SESSION['login'];
    if ($login->usuarios_nivel == 1) {
?>

<?= $this->extend('Templates_admin') ?>
<?= $this->section('content') ?>

<div class="container">
    <h2 class="border-bottom border-2 border-primary mt-3 mb-4"><?= $title ?></h2>

    <?php if (isset($msg)) echo $msg; ?>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Data</th>
                <th>Total</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vendas as $venda): ?>
            <tr>
                <td><?= $venda->vendas_id ?></td>
                <td><?= $venda->cliente_nome ?></td>
                <td><?= date('d/m/Y H:i', strtotime($venda->vendas_data)) ?></td>
                <td>R$ <?= moedaReal($venda->vendas_valor_total) ?></td>
                <td>
                    <a class="btn btn-primary" href="<?= base_url('venda/edit/' . $venda->vendas_id) ?>">
                        Editar <i class="bi bi-pencil-square"></i>
                    </a>
                    <a class="btn btn-danger" href="<?= base_url('venda/delete/' . $venda->vendas_id) ?>">
                        Excluir <i class="bi bi-x-circle"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>

<?php
    } else {
        echo view('login', ['msg' => msg("Sem permissão de acesso!", "danger")]);
    }
} else {
    echo view('login', ['msg' => msg("O usuário não está logado!", "danger")]);
}
?>
