<?php
    helper('functions');
    session();
    if(isset($_SESSION['login'])){
        $login = $_SESSION['login'];
        if($login->usuarios_nivel == 1){
?>
<?= $this->extend('Templates_admin') ?>
<?= $this->section('content') ?>

    <div class="container">

        <h2 class="border-bottom border-2 border-primary mt-3 mb-4"> <?= $title ?> </h2>

        <?php if(!empty($msg)){echo $msg;} ?>

        <form action="<?= base_url('cidades/search'); ?>" class="d-flex" role="search" method="post">
            <input class="form-control me-2" name="pesquisar" type="search"
                placeholder="Pesquisar por nome" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">
                <i class="bi bi-search"></i>
            </button>
        </form>

        <table class="table mt-3">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Cidade</th>
                    <th scope="col">Estado</th>
                    <th scope="col">
                        <a class="btn btn-success"  href="<?= base_url('cidades/new'); ?>">
                            Novo
                            <i class="bi bi-plus-circle"></i>
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                
                <?php foreach ($cidades as $cidade): ?>
                    <tr>
                        <th scope="row"><?= $cidade->cidades_id; ?></th>
                        <td><?= esc($cidade->cidades_nome); ?></td>
                        <td><?= esc($cidade->cidades_uf); ?></td>
                        <td>
                            <a class="btn btn-primary"  href="<?= base_url('cidades/edit/'.$cidade->cidades_id); ?>">
                                Editar
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a class="btn btn-danger"  href="<?= base_url('cidades/delete/'.$cidade->cidades_id); ?>">
                                Excluir
                                <i class="bi bi-x-circle"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>

    </div>
<?= $this->endSection() ?>

<?php 
        }else{
            echo view('login', ['msg' => msg("Sem permissão de acesso!", "danger")]);
        }
    }else{
        echo view('login', ['msg' => msg("O usuário não está logado!", "danger")]);
    }
?>