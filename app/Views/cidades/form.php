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
    <h2 class="border-bottom border-2 border-primary">
        <?= ucfirst($form) . ' ' . $title ?>
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

    <form action="<?= base_url('cidades/' . $op); ?>" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label for="cidades_nome" class="form-label">Cidade</label>
            <input type="text" class="form-control" name="cidades_nome"
                   value="<?= old('cidades_nome', $cidades->cidades_nome ?? '') ?>" id="cidades_nome" required>
        </div>

        <div class="mb-3">
            <label for="cidades_uf" class="form-label">Estado (UF)</label>
            <input type="text" class="form-control" name="cidades_uf" maxlength="2"
                   value="<?= old('cidades_uf', $cidades->cidades_uf ?? '') ?>" id="cidades_uf" required>
        </div>

        <?php if (!empty($cidades->cidades_id)): ?>
            <input type="hidden" name="cidades_id" value="<?= $cidades->cidades_id ?>">
        <?php endif; ?>

        <div class="mb-3">
            <button class="btn btn-success" type="submit">
                <?= ucfirst($form) ?> <i class="bi bi-floppy"></i>
            </button>
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