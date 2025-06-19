<?php
    $template = '';
    if (session()->has('login')) {
        $login = session()->get('login');
        if (in_array((int)$login->usuarios_nivel, [1, 2])) {
            $template = ($login->usuarios_nivel == 1) ? 'Templates_admin' : 'Templates_funcionario';
        }
    }
?>

<?php if ($template): ?>

<?= $this->extend($template) ?>
<?= $this->section('content') ?>

<div class="container pt-4 pb-5 bg-light">
    <h2 class="border-bottom border-2 border-primary mb-4"><?= esc($title ?? 'Formulário de Entrega') ?></h2>

    <form action="<?= base_url('entregas/' . ($op ?? '')) ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="entregas_vendas_id" class="form-label">Venda</label>
            <select name="entregas_vendas_id" class="form-select" required <?= !empty($entrega->entregas_vendas_id) ? 'disabled' : '' ?>>
                <option value="">Selecione a Venda</option>
                <?php foreach($vendas as $venda): ?>
                    <option value="<?= $venda->vendas_id ?>" <?= old('entregas_vendas_id', $entrega->entregas_vendas_id ?? '') == $venda->vendas_id ? 'selected' : '' ?>>
                        Venda #<?= $venda->vendas_id ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (!empty($entrega->entregas_vendas_id)): ?>
                <input type="hidden" name="entregas_vendas_id" value="<?= $entrega->entregas_vendas_id ?>">
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="entregas_funcionarios_id" class="form-label">Funcionário (Entregador)</label>
            <select name="entregas_funcionarios_id" class="form-select">
                <option value="">Selecione o Funcionário</option>
                <?php foreach($funcionarios as $funcionario): ?>
                    <option value="<?= $funcionario->funcionarios_id ?>" <?= old('entregas_funcionarios_id', $entrega->entregas_funcionarios_id ?? '') == $funcionario->funcionarios_id ? 'selected' : '' ?>>
                        <?= esc($funcionario->usuarios_nome) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="entregas_data" class="form-label">Data e Hora da Entrega</label>
            <input type="datetime-local" class="form-control" name="entregas_data" 
                   value="<?= old('entregas_data', !empty($entrega->entregas_data) ? date('Y-m-d\TH:i', strtotime($entrega->entregas_data)) : '') ?>" required>
        </div>

        <div class="mb-3">
            <label for="entregas_status" class="form-label">Status da Entrega</label>
            <select name="entregas_status" class="form-select" required>
                <?php $status_options = ['Pendente', 'Em Rota', 'Entregue', 'Cancelada']; ?>
                <?php foreach($status_options as $status): ?>
                    <option value="<?= $status ?>" <?= old('entregas_status', $entrega->entregas_status ?? 'Pendente') == $status ? 'selected' : '' ?>>
                        <?= $status ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-floppy"></i> <?= esc($form ?? '') ?>
        </button>
    </form>
</div>

<?= $this->endSection() ?>

<?php 
    else:
        echo view('login', ['msg' => msg("Sem permissão de acesso!", "danger")]);
    endif;
?>