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
        <?= esc(ucfirst($form ?? '')) ?> Estoque
    </h2>

    <form action="<?= base_url('estoques/' . ($op ?? '')) ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="estoques_produtos_id" class="form-label">Produto</label>
            <select class="form-select" name="estoques_produtos_id" id="estoques_produtos_id" required>
                <option value="">Selecione um produto</option>
                <?php foreach ($produtos as $produto): ?>
                    <option value="<?= $produto->produtos_id ?>" 
                        <?= old('estoques_produtos_id', $estoque->estoques_produtos_id ?? '') == $produto->produtos_id ? 'selected' : '' ?>>
                        <?= esc($produto->produtos_nome) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="estoques_quantidade" class="form-label">Quantidade</label>
            <input type="number" class="form-control" name="estoques_quantidade" id="estoques_quantidade" min="0"
                value="<?= old('estoques_quantidade', $estoque->estoques_quantidade ?? '0') ?>" required>
        </div>

        <?php if (!empty($estoque->estoques_id)): ?>
            <input type="hidden" name="estoques_id" value="<?= $estoque->estoques_id ?>">
        <?php endif; ?>

        <div class="mb-3">
            <button class="btn btn-success" type="submit">
                <?= esc(ucfirst($form ?? '')) ?> <i class="bi bi-floppy"></i>
            </button>
            <a href="<?= base_url('estoques'); ?>" class="btn btn-secondary ms-2">
                Cancelar <i class="bi bi-x-circle"></i>
            </a>
        </div>

    </form>
</div>

<?= $this->endSection() ?>

<?php 
    else:
        echo view('login', ['msg' => msg("Sem permissão de acesso!", "danger")]);
    endif;
?>