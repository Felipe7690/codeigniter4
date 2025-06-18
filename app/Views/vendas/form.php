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
        Editar Venda #<?= esc($venda->vendas_id) ?>
    </h2>

    <?php if (session('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('vendas/update/' . $venda->vendas_id) ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="vendas_clientes_id" class="form-label">Cliente</label>
            <select name="vendas_clientes_id" class="form-select" id="vendas_clientes_id" required>
                <option value="">Selecione um cliente</option>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?= $cliente->clientes_id ?>" <?= old('vendas_clientes_id', $venda->vendas_clientes_id) == $cliente->clientes_id ? 'selected' : '' ?>>
                        <?= esc($cliente->usuarios_nome) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="vendas_funcionarios_id" class="form-label">Funcionário Responsável</label>
            <select name="vendas_funcionarios_id" class="form-select" id="vendas_funcionarios_id">
                <option value="">Nenhum</option>
                <?php foreach ($funcionarios as $funcionario): ?>
                    <option value="<?= $funcionario->funcionarios_id ?>" <?= old('vendas_funcionarios_id', $venda->vendas_funcionarios_id ?? '') == $funcionario->funcionarios_id ? 'selected' : '' ?>>
                        <?= esc($funcionario->usuarios_nome) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="vendas_data" class="form-label">Data da Venda</label>
            <input type="datetime-local" name="vendas_data" id="vendas_data" class="form-control"
                   value="<?= old('vendas_data', date('Y-m-d\TH:i', strtotime($venda->vendas_data))) ?>" required>
        </div>

        <div class="mb-3">
            <label for="vendas_total" class="form-label">Valor Total (Calculado automaticamente)</label>
            <input type="number" name="vendas_total" id="vendas_total" class="form-control"
                   step="0.01" value="<?= esc($venda->vendas_total) ?>" readonly>
        </div>

        <div class="mb-3">
            <label for="vendas_status" class="form-label">Status</label>
            <select name="vendas_status" class="form-select" required>
                <?php $status_options = ['Aberta', 'Realizada', 'Cancelada']; ?>
                <?php foreach($status_options as $status): ?>
                    <option value="<?= $status ?>" <?= old('vendas_status', $venda->vendas_status) == $status ? 'selected' : '' ?>>
                        <?= $status ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Salvar Alterações <i class="bi bi-floppy"></i></button>
            <a href="<?= base_url('vendas') ?>" class="btn btn-secondary">Cancelar</a>
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