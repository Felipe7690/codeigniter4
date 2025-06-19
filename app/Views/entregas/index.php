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
    <h2 class="border-bottom border-2 border-primary mt-3 mb-4"><?= esc($title ?? 'Gerenciamento de Entregas') ?></h2>
    
    <?php if(!empty($msg)){echo $msg;} ?>

    <div class="text-end">
        <a class="btn btn-success" href="<?= base_url('entregas/new') ?>">
            <i class="bi bi-plus-circle"></i> Nova Entrega
        </a>
    </div>

    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Venda (Cliente)</th>
                <th>Entregador</th>
                <th>Data/Hora</th>
                <th>Status</th>
                <th class="text-end">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($entregas)): ?>
                <?php foreach ($entregas as $entrega): ?>
                <tr>
                    <td><?= $entrega->entregas_id ?></td>
                    <td>Venda #<?= $entrega->vendas_id ?> (<?= esc($entrega->cliente_nome) ?>)</td>
                    <td><?= esc($entrega->funcionario_nome ?? 'Não definido') ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($entrega->entregas_data)) ?></td>
                    <td><span class="badge bg-info text-dark"><?= esc($entrega->entregas_status) ?></span></td>
                    <td class="text-end">
                        <a class="btn btn-secondary btn-sm" href="<?= base_url('entregas/edit/' . $entrega->entregas_id) ?>">
                            <i class="bi bi-pencil-square"></i> Editar
                        </a>
                        <a class="btn btn-danger btn-sm" href="<?= base_url('entregas/delete/' . $entrega->entregas_id) ?>" onclick="return confirm('Tem certeza?');">
                            <i class="bi bi-x-circle"></i> Excluir
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