<?= $this->extend('Templates_admin') ?>
<?= $this->section('content') ?>

<div class="container pt-4 pb-5 bg-light">
    <h2 class="border-bottom border-2 border-primary mb-4">
        Editar Venda #<?= $venda->vendas_id ?>
    </h2>

    <form action="<?= base_url('venda/update/' . $venda->vendas_id) ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="vendas_clientes_id" class="form-label">Cliente</label>
            <select class="form-select" name="vendas_clientes_id" id="vendas_clientes_id" required>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?= $cliente->clientes_id ?>" <?= $venda->vendas_clientes_id == $cliente->clientes_id ? 'selected' : '' ?>>
                        <?= esc($cliente->usuarios_nome) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="vendas_funcionarios_id" class="form-label">Funcionário</label>
            <select class="form-select" name="vendas_funcionarios_id" id="vendas_funcionarios_id">
                <option value="">Nenhum</option>
                <?php foreach ($funcionarios as $funcionario): ?>
                    <option value="<?= $funcionario->funcionarios_id ?>" <?= $venda->vendas_funcionarios_id == $funcionario->funcionarios_id ? 'selected' : '' ?>>
                        <?= esc($funcionario->usuarios_nome) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="vendas_data" class="form-label">Data</label>
            <input type="datetime-local" class="form-control" name="vendas_data" id="vendas_data"
                value="<?= date('Y-m-d\TH:i', strtotime($venda->vendas_data)) ?>" required>
        </div>

        <div class="mb-3">
            <label for="vendas_total" class="form-label">Total (calculado automaticamente)</label>
            <input type="number" step="0.01" class="form-control" name="vendas_total" id="vendas_total"
                value="<?= esc($venda->vendas_total) ?>" readonly>
        </div>

        <div class="mb-3">
            <label for="vendas_status" class="form-label">Status</label>
             <select name="vendas_status" class="form-select" required>
                <?php $status_options = ['Aberta', 'Realizada', 'Cancelada']; ?>
                <?php foreach($status_options as $status): ?>
                    <option value="<?= $status ?>" <?= $venda->vendas_status == $status ? 'selected' : '' ?>>
                        <?= $status ?>
                    </option>
                <?php endforeach; ?>
            </select>
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