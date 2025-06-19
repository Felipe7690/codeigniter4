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

        <h2 class="border-bottom border-2 border-primary mt-3 mb-4"> <?= esc($title ?? 'Categorias') ?> </h2>

        <?php if(!empty($msg)){echo $msg;} ?>

        <form action="<?= base_url('categorias/search'); ?>" class="d-flex mb-3" role="search" method="post">
            <input class="form-control me-2" name="pesquisar" type="search"
                placeholder="Pesquisar por categoria" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">
            <i class="bi bi-search"></i>
            </button>
        </form>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Categoria</th>
                    <th scope="col" class="text-end">
                        <a class="btn btn-success"  href="<?= base_url('categorias/new'); ?>">
                            <i class="bi bi-plus-circle"></i> Novo
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                
                <?php foreach ($categorias as $categoria): ?>
                    <tr>
                        <th scope="row"><?= $categoria->categorias_id; ?></th>
                        <td><?= esc($categoria->categorias_nome); ?></td>
                        <td class="text-end">
                            <a class="btn btn-primary btn-sm"  href="<?= base_url('categorias/edit/'.$categoria->categorias_id); ?>">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                            <a class="btn btn-danger btn-sm"  href="<?= base_url('categorias/delete/'.$categoria->categorias_id); ?>" onclick="return confirm('Tem certeza? Excluir uma categoria pode afetar os produtos associados.');">
                                <i class="bi bi-x-circle"></i> Excluir
                            </a>
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