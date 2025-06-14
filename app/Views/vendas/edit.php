<?php
helper('functions');
session();
if (isset($_SESSION['login'])) {
    $login = $_SESSION['login'];
    if ($login->usuarios_nivel == 1) {
?>

<?= $this->extend('Templates_admin') ?>
<?= $this->section('content') ?>

<div class="container pt-4 pb-5 bg-light">
    <h2 class="border-bottom border-2 border-primary">
        Editar Venda
    </h2>

    <?php if (session('errors')): ?>
        <div class="alert alert-danger">
            <?= implode('<br>', session('errors')) ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('venda/update/' . $venda->vendas_id) ?>" method="post">
        <input type="hidden" name="vendas_id" value="<?= $venda->vendas_id ?>">

        <div class="mb-3">
            <label for="vendas_clientes_id" class="form-label">Cliente</label>
            <select name="vendas_clientes_id" class="form-control" id="vendas_clientes_id" required>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?= $cliente->clientes_id ?>" <?= $venda->vendas_clientes_id == $cliente->clientes_id ? 'selected' : '' ?>>
                        <?= esc($cliente->usuarios_nome) ?> - <?= esc($cliente->clientes_endereco) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="vendas_data" class="form-label">Data</label>
            <input type="datetime-local" name="vendas_data" id="vendas_data" class="form-control"
                   value="<?= date('Y-m-d\TH:i', strtotime($venda->vendas_data)) ?>" required>
        </div>

        <div class="mb-3">
            <label for="vendas_valor_total" class="form-label">Valor Total</label>
            <input type="number" name="vendas_valor_total" id="vendas_valor_total" class="form-control"
                   step="0.01" value="<?= esc($venda->vendas_valor_total) ?>" required>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-success">Salvar <i class="bi bi-floppy"></i></button>
            <a href="<?= base_url('venda') ?>" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
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
