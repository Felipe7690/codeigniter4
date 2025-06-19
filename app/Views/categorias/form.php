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

    <form action="<?= base_url('categorias/' . ($op ?? '')); ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="categorias_nome" class="form-label">Nome da Categoria</label>
            <input type="text" class="form-control" name="categorias_nome" id="categorias_nome"
                   value="<?= old('categorias_nome', $categorias->categorias_nome ?? '') ?>" required>
        </div>

        <?php if (!empty($categorias->categorias_id)): ?>
            <input type="hidden" name="categorias_id" value="<?= $categorias->categorias_id ?>">
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
        echo view('login', ['msg' => msg("Sem permissão de acesso!", "danger")]);
    endif;
?>