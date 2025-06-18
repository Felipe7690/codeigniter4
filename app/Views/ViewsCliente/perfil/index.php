<?php
helper('functions');
session();

$usuario = session('login');
?>

<?= $this->extend('Templates_user') ?>
<?= $this->section('content') ?>

<div class="container">

    <h2 class="border-bottom border-2 border-primary mt-5 pt-3 mb-4">Meu Perfil</h2>

    <?php if (isset($msg)) echo $msg; ?>

    <table class="table table-bordered mt-4">
        <tr>
            <th>Nome</th>
            <td><?= esc($usuario->usuarios_nome . ' ' . $usuario->usuarios_sobrenome) ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= esc($usuario->usuarios_email) ?></td>
        </tr>
        <tr>
            <th>CPF</th>
            <td><?= esc($usuario->usuarios_cpf) ?></td>
        </tr>
        <tr>
            <th>Nível de Acesso</th>
            <td>
                <?php
                    switch ($usuario->usuarios_nivel) {
                        case 0: echo 'Cliente'; break;
                        case 1: echo 'Administrador'; break;
                        default: echo 'Desconhecido'; break;
                    }
                ?>
            </td>
        </tr>
    </table>
                    

</div>

<?= $this->endSection() ?>
