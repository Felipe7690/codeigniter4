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

        <?= form_open_multipart('imgprodutos/' . ($op ?? ''))  ?>
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="imgprodutos_descricao" class="form-label">Descrição da Imagem</label>
                <input type="text" class="form-control" name="imgprodutos_descricao" id="imgprodutos_descricao" 
                       value="<?= old('imgprodutos_descricao', $imgproduto->imgprodutos_descricao ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label for="imgprodutos_produtos_id" class="form-label">Associar ao Produto</label>
                <select class="form-select" name="imgprodutos_produtos_id" id="imgprodutos_produtos_id" required>
                    <option value="">Selecione um produto</option>
                    <?php if (!empty($produtos)): ?>
                        <?php foreach($produtos as $produto): ?>
                            <option value="<?= $produto->produtos_id; ?>" <?= old('imgprodutos_produtos_id', $imgproduto->imgprodutos_produtos_id ?? '') == $produto->produtos_id ? 'selected' : '' ?>>
                                <?= esc($produto->produtos_nome); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="imgprodutos_link" class="form-label">Arquivo de Imagem (Upload)</label>
                <input type="file" class="form-control" name="imgprodutos_link" id="imgprodutos_link">
                <small class="form-text text-muted">Selecione uma nova imagem apenas se desejar substituí-la.</small>
            </div>

            <?php if (!empty($imgproduto->imgprodutos_link)): ?>
                <div class="mb-3">
                    <p>Imagem Atual:</p>
                    <img src="<?= base_url($imgproduto->imgprodutos_link) ?>" alt="<?= esc($imgproduto->imgprodutos_descricao) ?>" class="img-thumbnail" width="150">
                </div>
            <?php endif; ?>

            <?php if (!empty($imgproduto->imgprodutos_id)): ?>
                <input type="hidden" name="imgprodutos_id" value="<?= $imgproduto->imgprodutos_id; ?>">
            <?php endif; ?>

            <div class="mb-3">
                <button class="btn btn-success" type="submit"> <?= esc(ucfirst($form ?? '')) ?> <i class="bi bi-floppy"></i></button>
            </div>
        
        </form>
    </div>

<?= $this->endSection() ?>

<?php 
    else:
        echo view('login', ['msg' => msg("Sem permissão de acesso!", "danger")]);
    endif;
?>