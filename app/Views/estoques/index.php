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

<div class="container">

    <h2 class="border-bottom border-2 border-primary mt-5 pt-3 mb-4"> <?= esc($title ?? 'Controle de Estoque') ?> </h2>

    <?php if (!empty($msg)) { echo $msg; } ?>

    <form action="<?= base_url('estoques/search'); ?>" class="d-flex" role="search" method="post">
        <input class="form-control me-2" name="pesquisar" type="search" placeholder="Pesquisar por produto" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">
            <i class="bi bi-search"></i>
        </button>
    </form>

    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Produto</th>
                <th scope="col">Quantidade</th>
                <th scope="col" class="text-end">
                    <a class="btn btn-success" href="<?= base_url('estoques/create'); ?>">
                        <i class="bi bi-plus-circle"></i> Novo
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
                    <td class="text-end">
                        <a class="btn btn-primary btn-sm" href="<?= base_url('estoques/edit/' . $estoque->estoques_id); ?>">
                            <i class="bi bi-pencil-square"></i> Editar
                        </a>
                        <form action="<?= base_url('estoques/delete/' . $estoque->estoques_id); ?>" method="post" style="display:inline;" onsubmit="return confirm('Confirma a exclusão deste item do estoque?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-x-circle"></i> Excluir
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>

</div>

<?= $this->endSection() ?>

<?php 
    else:
        echo view('login', ['msg' => msg("Sem permissão de acesso!", "danger")]);
    endif;
?>