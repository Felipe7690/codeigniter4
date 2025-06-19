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

    <form action="<?= base_url('produtos/' . ($op ?? '')) ?>" method="post">
        <?= csrf_field() ?>
        
        <div class="mb-3">
            <label for="produtos_nome" class="form-label">Nome do Produto</label>
            <input type="text" class="form-control" name="produtos_nome" id="produtos_nome"
                   value="<?= old('produtos_nome', $produto->produtos_nome ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label for="produtos_descricao" class="form-label">Descrição</label>
            <textarea class="form-control" name="produtos_descricao" id="produtos_descricao" rows="3"><?= old('produtos_descricao', $produto->produtos_descricao ?? '') ?></textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="produtos_preco_custo" class="form-label">Preço de Custo</label>
                <input type="text" class="form-control" name="produtos_preco_custo" id="produtos_preco_custo"
                       value="<?= old('produtos_preco_custo', isset($produto->produtos_preco_custo) ? number_format($produto->produtos_preco_custo, 2, ',', '.') : '0,00') ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="produtos_preco_venda" class="form-label">Preço de Venda</label>
                <input type="text" class="form-control" name="produtos_preco_venda" id="produtos_preco_venda"
                       value="<?= old('produtos_preco_venda', isset($produto->produtos_preco_venda) ? number_format($produto->produtos_preco_venda, 2, ',', '.') : '0,00') ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="produtos_categorias_id" class="form-label">Categoria</label>
            <select name="produtos_categorias_id" class="form-select" required>
                <option value="">Selecione uma categoria</option>
                <?php if (!empty($categorias)): ?>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria->categorias_id ?>" <?= old('produtos_categorias_id', $produto->produtos_categorias_id ?? '') == $categoria->categorias_id ? 'selected' : '' ?>>
                            <?= esc($categoria->categorias_nome) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <?php if (!empty($produto->produtos_id)): ?>
            <input type="hidden" name="produtos_id" value="<?= $produto->produtos_id; ?>">
        <?php endif; ?>

        <div class="mb-3">
            <button class="btn btn-success" type="submit">
                <?= esc(ucfirst($form ?? '')) ?> <i class="bi bi-floppy"></i>
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?php 
    else:
        $data['msg'] = msg("Sem permissão de acesso!", "danger");
        echo view('login', $data);
    endif;
?>