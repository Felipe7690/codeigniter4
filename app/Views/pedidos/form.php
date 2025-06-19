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
    <h2 class="border-bottom border-2 border-primary">
        <?= esc(ucfirst($form ?? '')) . ' ' . esc($title ?? '') ?>
    </h2>

    <?php if (!empty(session()->getFlashdata('errors'))): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('pedidos/' . ($op ?? '')); ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="pedidos_vendas_id" class="form-label">Venda</label>
            <select name="pedidos_vendas_id" id="pedidos_vendas_id" class="form-select" required onchange="toggleNovaVenda(this.value)">
                <option value="">Selecione uma venda existente</option>
                <?php foreach ($vendas as $venda): ?>
                <option value="<?= $venda->vendas_id ?>"
                    <?= old('pedidos_vendas_id', $pedidos->pedidos_vendas_id ?? '') == $venda->vendas_id ? 'selected' : '' ?>>
                    Venda #<?= $venda->vendas_id ?>
                </option>
                <?php endforeach; ?>
                <option value="nova" <?= old('pedidos_vendas_id') == 'nova' ? 'selected' : '' ?>>+ Criar nova venda</option>
            </select>
        </div>

        <div id="novaVendaCampos" style="display: <?= (old('pedidos_vendas_id') == 'nova') ? 'block' : 'none' ?>;" class="p-3 mb-3 border rounded bg-white">
            <h5 class="mb-3">Dados da Nova Venda</h5>
            <div class="mb-3">
                <label for="clientes_id" class="form-label">Cliente para a Nova Venda</label>
                <select name="clientes_id" id="clientes_id" class="form-select" <?= (old('pedidos_vendas_id') == 'nova') ? 'required' : '' ?>>
                    <option value="">Selecione um cliente</option>
                    <?php if (!empty($clientes)): ?>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?= $cliente->clientes_id ?>" <?= old('clientes_id') == $cliente->clientes_id ? 'selected' : '' ?>>
                                <?= esc($cliente->usuarios_nome) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <small class="form-text text-muted">Este cliente será associado à nova venda a ser criada.</small>
            </div>
        </div>

        <div class="mb-3">
            <label for="pedidos_produtos_id" class="form-label">Produto</label>
            <select name="produtos_id" id="pedidos_produtos_id" class="form-select" required>
                <option value="">Selecione um produto</option>
                <?php foreach ($produtos as $produto): ?>
                    <option value="<?= $produto->produtos_id ?>"
                        <?= old('produtos_id', $pedidos->pedidos_produtos_id ?? '') == $produto->produtos_id ? 'selected' : '' ?>>
                        <?= esc($produto->produtos_nome) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="pedidos_quantidade" class="form-label">Quantidade</label>
            <input type="number" class="form-control" name="pedidos_quantidade"
                   value="<?= old('pedidos_quantidade', $pedidos->pedidos_quantidade ?? '1') ?>" id="pedidos_quantidade" required>
        </div>

        <div class="mb-3">
            <label for="pedidos_preco_unitario" class="form-label">Preço Unitário</label>
            <input type="number" step="0.01" class="form-control" name="pedidos_preco_unitario"
                   value="<?= old('pedidos_preco_unitario', $pedidos->pedidos_preco_unitario ?? '0.00') ?>" id="pedidos_preco_unitario" required>
        </div>

        <?php if (!empty($pedidos->pedidos_id)): ?>
            <input type="hidden" name="pedidos_id" value="<?= $pedidos->pedidos_id ?>">
        <?php endif; ?>

        <div class="mb-3">
            <button class="btn btn-success" type="submit">
                <?= esc(ucfirst($form ?? '')) ?> <i class="bi bi-floppy"></i>
            </button>
        </div>
    </form>
</div>

<script>
function toggleNovaVenda(value) {
    const novaVendaDiv = document.getElementById('novaVendaCampos');
    const clienteSelect = document.getElementById('clientes_id');

    if (value === 'nova') {
        novaVendaDiv.style.display = 'block';
        clienteSelect.setAttribute('required', 'required');
    } else {
        novaVendaDiv.style.display = 'none';
        clienteSelect.removeAttribute('required');
    }
}
</script>

<?= $this->endSection() ?>

<?php 
    else:
        echo view('login', ['msg' => msg("Sem permissão de acesso!", "danger")]);
    endif;
?>