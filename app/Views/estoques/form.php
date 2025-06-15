<?php
    helper('functions');
    session();
?>

<?= $this->extend('Templates_admin') ?>
<?= $this->section('content') ?>

<div class="container pt-4 pb-5 bg-light">
    <h2 class="border-bottom border-2 border-primary">
        <?= isset($form_label) ? $form_label : ucfirst($form) ?> Estoque
    </h2>

    <form action="<?= base_url('estoques/' . ($form == 'editar' ? 'update/'.$estoque->estoques_id : 'store')) ?>" method="post">

        <div class="mb-3">
            <label for="estoques_produtos_id" class="form-label">Produto</label>
            <select class="form-select" name="estoques_produtos_id" id="estoques_produtos_id" required>
                <option value="">Selecione um produto</option>
                <?php foreach ($produtos as $produto): ?>
                    <option value="<?= $produto->produtos_id ?>" 
                        <?= (isset($estoque) && $estoque->estoques_produtos_id == $produto->produtos_id) ? 'selected' : '' ?>>
                        <?= esc($produto->produtos_nome) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="estoques_quantidade" class="form-label">Quantidade</label>
            <input type="number" class="form-control" name="estoques_quantidade" id="estoques_quantidade" min="0"
                value="<?= isset($estoque) ? esc($estoque->estoques_quantidade) : '' ?>" required>
        </div>

        <div class="mb-3">
            <button class="btn btn-success" type="submit">
                <?= isset($form_label) ? $form_label : ucfirst($form) ?> <i class="bi bi-floppy"></i>
            </button>
            <a href="<?= base_url('estoques'); ?>" class="btn btn-secondary ms-2">
                Cancelar <i class="bi bi-x-circle"></i>
            </a>
        </div>

    </form>
</div>

<?= $this->endSection() ?>
