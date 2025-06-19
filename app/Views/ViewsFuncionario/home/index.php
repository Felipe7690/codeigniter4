<?php
$login = session()->get('login');
?>

<?= $this->extend('Templates_funcionario') ?>

<?= $this->section('content') ?>

<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-white px-3 py-2 shadow-sm rounded">
            <li class="breadcrumb-item"><a href="<?= base_url('funcionario') ?>">Funcionário</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>

    <div class="d-flex align-items-center mb-4">
        <h2 class="me-3 text-primary"><i class="bi bi-person-badge-fill"></i> Painel do Funcionário</h2>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="card-title text-muted mb-4">Seus Dados</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h6 class="text-muted">Nome Completo</h6>
                    <p class="mb-0 fs-5"><?= esc($login->usuarios_nome) . ' ' . esc($login->usuarios_sobrenome) ?></p>
                </div>

                <div class="col-md-6 mb-3">
                    <h6 class="text-muted">Cargo</h6>
                    <p class="mb-0 fs-5"><?= esc($funcionario->funcionarios_cargo ?? 'Não informado') ?></p>
                </div>

                <div class="col-md-6 mb-3">
                    <h6 class="text-muted">Email</h6>
                    <p class="mb-0"><?= esc($login->usuarios_email) ?></p>
                </div>

                <div class="col-md-6 mb-3">
                    <h6 class="text-muted">Telefone</h6>
                    <p class="mb-0"><?= esc($login->usuarios_fone) ?></p>
                </div>

                <div class="col-md-6 mb-3">
                    <h6 class="text-muted">CPF</h6>
                    <p class="mb-0"><?= esc($login->usuarios_cpf) ?></p>
                </div>

                <div class="col-md-6 mb-3">
                    <h6 class="text-muted">Salário</h6>
                    <p class="mb-0">R$ <?= isset($funcionario->funcionarios_salario) ? moedaReal($funcionario->funcionarios_salario) : 'Não informado' ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>