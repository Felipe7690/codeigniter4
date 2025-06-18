<!-- Abre o menu de navegação -->
<nav class="navbar bg-dark navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= base_url('/') ?>">
            <!--Logo do Projeto-->
            <img src="<?= base_url('assets/images/sd_logo.png') ?>" alt="SysDelivery" width="180">
        </a>

        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <!-- Link Home -->
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'cliente/home' ? 'active' : '' ?>" href="<?= base_url('cliente/home') ?>">
                        <i class="bi bi-house-fill"></i>
                        Produtos
                    </a>
                </li>

                <!-- Link Perfil -->
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'user/perfil' ? 'active' : '' ?>" href="<?= base_url('user/perfil') ?>">
                        <i class="bi bi-person"></i>
                        Perfil
                    </a>
                </li>

                <!-- Link Endereço -->
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'cliente/endereco' ? 'active' : '' ?>" href="<?= base_url('cliente/endereco') ?>">
                        <i class="bi bi-geo-alt-fill"></i>
                        Endereço
                    </a>
                </li>

                <!-- Link Meus Pedidos -->
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'cliente/pedidos' ? 'active' : '' ?>" href="<?= base_url('cliente/pedidos') ?>">
                        <i class="bi bi-basket"></i>
                        Meus Pedidos
                    </a>
                </li>

            </ul>

            <div class="d-flex">
                <a class="btn btn-outline-primary me-2" href="<?= base_url('login/logout') ?>">
                    <i class="bi bi-unlock"></i>
                    Sair
                </a>
            </div>
        </div>
    </div>
</nav>
<!-- Fecha o menu de navegação -->
