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
    <h2 class="border-bottom border-2 border-primary mb-4">
        Editar Venda
    </h2>

    <?php if (session('errors')): ?>
        <div class="alert alert-danger">
            <?= implode('<br>', session('errors')) ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('venda/update/' . $vendas->vendas_id) ?>" method="post">
        <input type="hidden" name="vendas_id" value="<?= $vendas->vendas_id ?>">

        <div class="mb-3">
            <label for="vendas_clientes_id" class="form-label">Cliente</label>
            <select class="form-control" name="vendas_clientes_id" id="vendas_clientes_id" required>
                <?php foreach ($clientes as $cliente) : 
                    $selected = ($cliente->clientes_id == $vendas->vendas_clientes_id) ? 'selected' : '';
                ?>
                    <option value="<?= $cliente->clientes_id ?>" <?= $selected ?>>
                        <?= esc($cliente->clientes_nome) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="vendas_funcionarios_id" class="form-label">Funcionário</label>
            <select class="form-control" name="vendas_funcionarios_id" id="vendas_funcionarios_id" required>
                <?php foreach ($funcionarios as $funcionario) : 
                    $selected = ($funcionario->funcionarios_id == $vendas->vendas_funcionarios_id) ? 'selected' : '';
                ?>
                    <option value="<?= $funcionario->funcionarios_id ?>" <?= $selected ?>>
                        <?= esc($funcionario->funcionarios_nome) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="vendas_data" class="form-label">Data</label>
            <input type="datetime-local" class="form-control" name="vendas_data" id="vendas_data"
                value="<?= date('Y-m-d\TH:i', strtotime($vendas->vendas_data)) ?>" required>
        </div>

        <div class="mb-3">
            <label for="vendas_total" class="form-label">Total</label>
            <input type="number" step="0.01" class="form-control" name="vendas_total" id="vendas_total"
                value="<?= esc($vendas->vendas_total) ?>" required>
        </div>

        <div class="mb-3">
            <label for="vendas_status" class="form-label">Status</label>
            <input type="text" class="form-control" name="vendas_status" id="vendas_status"
                value="<?= esc($vendas->vendas_status) ?>" required>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-success">
                Salvar <i class="bi bi-floppy"></i>
            </button>
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
