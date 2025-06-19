<?php $login = session()->get('login'); ?>

<?= $this->extend('Templates_admin') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-white px-3 py-2 shadow-sm rounded">
            <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Admin</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>

    <div class="d-flex align-items-center mb-4">
        <h2 class="me-3 text-primary"><i class="bi bi-person-circle"></i> Painel do Administrador</h2>
    </div>

    <div class="card shadow-sm border-0 mb-5">
        <div class="card-body">
            <h5 class="card-title text-muted mb-4">Bem-vindo(a), <span class="text-dark"><?= esc($login->usuarios_nome) ?></span>!</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h6 class="text-muted">Nome Completo</h6>
                    <p class="mb-0"><?= esc($login->usuarios_nome) . ' ' . esc($login->usuarios_sobrenome) ?></p>
                </div>

                <div class="col-md-6 mb-3">
                    <h6 class="text-muted">Nível de Acesso</h6>
                    <p class="mb-0"><span class="badge bg-danger">Administrador</span></p>
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
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>