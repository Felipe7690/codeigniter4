<?php
    helper('functions');
    session();
?>

<?= $this->extend('Templates_admin') ?>
<?= $this->section('content') ?>

<div class="container">

    <h2 class="border-bottom border-2 border-primary mt-5 pt-3 mb-4"> <?= $title ?> </h2>

    <?php if (isset($msg)) echo $msg; ?>

    <form action="<?= base_url('estoques/search'); ?>" class="d-flex" role="search" method="post">
        <input class="form-control me-2" name="pesquisar" type="search" placeholder="Pesquisar" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">
            <i class="bi bi-search"></i>
        </button>
    </form>

    <br>
    <p>De acordo com os ingredientes disponíveis, será possivel montar os seguintes produtos...</p>

    <table class="table mt-4">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Produto</th>
                <th scope="col">Quantidade</th>
                <th scope="col">
                    <a class="btn btn-success" href="<?= base_url('estoques/create'); ?>">
                        Novo
                        <i class="bi bi-plus-circle"></i>
                    </a>
                </th>
            </tr>
        </thead>
        <tbody class="table-group-divider">

            <?php foreach ($estoques as $estoque): ?>
                <tr>
                    <th scope="row"><?= esc($estoque->estoques_id) ?></th>
                    <td><?= esc($estoque->produtos_nome) ?></td>
                    <td><?= esc($estoque->estoques_quantidade) ?></td>
                    <td>
                        <a class="btn btn-primary" href="<?= base_url('estoques/edit/' . $estoque->estoques_id); ?>">
                            Editar
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="<?= base_url('estoques/delete/' . $estoque->estoques_id); ?>" method="post" style="display:inline;" onsubmit="return confirm('Confirma a exclusão deste item do estoque?')">
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
