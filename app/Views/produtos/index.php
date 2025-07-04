<?php
    helper('functions');
    
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

    <h2 class="border-bottom border-2 border-primary mt-3 mb-4"> <?= esc($title ?? '') ?> </h2>

    <?php if(isset($msg)){echo $msg;} ?>

    <form action="<?= base_url('produtos/search'); ?>" class="d-flex" role="search" method="post">
        <input class="form-control me-2" name="pesquisar" type="search"
            placeholder="Pesquisar" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">
            <i class="bi bi-search"></i>
        </button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Produto</th>
                <th scope="col">Preço de Custo</th>
                <th scope="col">Preço de Venda</th>
                <th scope="col">Categoria</th>
                <th scope="col">
                    <a class="btn btn-success"  href="<?= base_url('produtos/new'); ?>">
                        Novo
                        <i class="bi bi-plus-circle"></i>
                    </a>
                </th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php if (!empty($produtos)): ?>
                <?php foreach ($produtos as $produto): ?>
                    <tr>
                        <th scope="row"><?= $produto->produtos_id; ?></th>
                        <td><?= esc($produto->produtos_nome); ?></td>
                        <td>R$ <?= moedaReal($produto->produtos_preco_custo); ?></td>
                        <td>R$ <?= moedaReal($produto->produtos_preco_venda); ?></td>
                        <td><?= esc($produto->categorias_nome); ?></td>
                        <td>
                            <a class="btn btn-primary"  href="<?= base_url('produtos/edit/'.$produto->produtos_id); ?>">
                                Editar
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a class="btn btn-danger"  href="<?= base_url('produtos/delete/'.$produto->produtos_id); ?>" onclick="return confirm('Tem certeza?');">
                                Excluir
                                <i class="bi bi-x-circle"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>

<?php 
    else:
        echo view('login', ['msg' => msg("Sem permissão de acesso!", "danger")]);
    endif;
?>