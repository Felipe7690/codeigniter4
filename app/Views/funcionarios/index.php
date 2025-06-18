<?php
helper('functions');
session();
?>

<?= $this->extend('Templates_admin') ?>
<?= $this->section('content') ?>

<div class="container">

    <h2 class="border-bottom border-2 border-primary mt-5 pt-3 mb-4"><?= esc($title) ?></h2>

    <?php if (isset($msg)) echo $msg; ?>

    <form action="<?= base_url('funcionarios'); ?>" method="get" class="d-flex" role="search">
    <input
        class="form-control me-2"
        name="q"
        type="search"
        placeholder="Pesquisar"
        aria-label="Pesquisar"
        value="<?= isset($search) ? esc($search) : '' ?>"
    >
    <button class="btn btn-outline-success" type="submit">
        <i class="bi bi-search"></i>
    </button>
</form>


    <table class="table mt-4">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Cargo</th>
                <th scope="col">Salário</th>
                <th scope="col">
                    <a class="btn btn-success" href="<?= base_url('funcionarios/create'); ?>">
                        Novo
                        <i class="bi bi-plus-circle"></i>
                    </a>
                </th>
            </tr>
        </thead>
        <tbody class="table-group-divider">

            <?php foreach ($funcionarios as $f): ?>
                <tr>
                    <th scope="row"><?= esc($f->funcionarios_id) ?></th>
                    <td><?= esc($f->usuarios_nome) ?></td>
                    <td><?= esc($f->funcionarios_cargo) ?></td>
                    <td>R$ <?= number_format($f->funcionarios_salario, 2, ',', '.') ?></td>
                    <td>
                        <a class="btn btn-primary" href="<?= base_url('funcionarios/edit/' . $f->funcionarios_id); ?>">
                            Editar
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="<?= base_url('funcionarios/delete/' . $f->funcionarios_id); ?>" method="post" style="display:inline;" onsubmit="return confirm('Confirma a exclusão deste funcionário?')">
                            <button type="submit" class="btn btn-danger">
                                Excluir
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>

</div>

<?= $this->endSection() ?>
