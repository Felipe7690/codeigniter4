<?php
helper('functions');
session();

if (isset($_SESSION['login'])) {
    $login = $_SESSION['login'];

    if ($login->usuarios_nivel == 1) {
?>

<?= $this->extend('Templates_admin') ?>
<?= $this->section('content') ?>

<div class="container">
    <h2 class="border-bottom border-2 border-primary mt-3 mb-4"> <?= esc($title) ?> </h2>

    <?php if (!empty($msg)) { echo $msg; } ?>

    <form action="<?= base_url('pedidos/search'); ?>" class="d-flex mb-3" method="post">
        <input class="form-control me-2" name="pesquisar" type="search"
               placeholder="Pesquisar..." aria-label="Search">
        <button class="btn btn-outline-success" type="submit">
            <i class="bi bi-search"></i>
        </button>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Pedido</th>
                <th>Venda (Cliente)</th>
                <th>Produto</th>
                <th>Qtd.</th>
                <th>Preço Unit.</th>
                <th class="text-end">
                    <a class="btn btn-success" href="<?= base_url('pedidos/new'); ?>">
                        <i class="bi bi-plus-circle"></i> Novo
                    </a>
                </th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?= $pedido->pedidos_id ?></td>
                    <td>Venda #<?= $pedido->pedidos_vendas_id ?> (<?= esc($pedido->cliente_nome) ?>)</td>
                    <td><?= esc($pedido->produtos_nome) ?></td>
                    <td><?= $pedido->pedidos_quantidade ?></td>
                    <td>R$ <?= moedaReal($pedido->pedidos_preco_unitario) ?></td>
                    <td class="text-end">
                        <a class="btn btn-primary btn-sm" href="<?= base_url('pedidos/edit/' . $pedido->pedidos_id); ?>">
                            <i class="bi bi-pencil-square"></i> Editar
                        </a>
                        <a class="btn btn-danger btn-sm" href="<?= base_url('pedidos/delete/' . $pedido->pedidos_id); ?>" 
                           onclick="return confirm('Tem certeza que deseja excluir este item do pedido?');">
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
    } else {
        echo view('login', ['msg' => msg("Sem permissão de acesso!", "danger")]);
    }
} else {
    echo view('login', ['msg' => msg("O usuário não está logado!", "danger")]);
}
?>