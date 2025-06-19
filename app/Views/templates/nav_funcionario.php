<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5">
    <div class="container-fluid">

        <a class="navbar-brand" href="<?php echo base_url('/') ?>">
            <img src="<?php echo base_url('assets/images/sd_logo.png') ?>" alt="SysDelivery" width="180">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <!-- Link Home-->
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?php echo base_url('funcionario') ?>">
                        <i class="bi bi-house-fill"></i>
                        Home
                    </a>
                </li>

                <!-- Link Produtos-->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('produtos') ?>">
                        <i class="bi bi-basket"></i>
                        Produtos
                    </a>
                </li>

                <!-- Link IMG Produtos-->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('imgprodutos') ?>">
                        <i class="bi bi-images"></i>
                        IMG Produtos
                    </a>
                </li>

                <!-- Link Categorias-->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('categorias') ?>">
                        <i class="bi bi-file-earmark-text"></i>
                        Categorias
                    </a>
                </li>

                <!-- Link Estoques -->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('estoques') ?>">
                        <i class="bi bi-archive"></i>
                        Estoques
                    </a>
                </li>

                <!-- Link Pedidos -->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('pedidos') ?>">
                        <i class="bi bi-table"></i>
                        Pedidos
                    </a>
                </li>

                <!-- Link Vendas -->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('vendas') ?>">
                        <i class="bi bi-receipt-cutoff"></i>
                        Vendas
                    </a>
                </li>

                <!-- Link Entregas -->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('entregas') ?>">
                        <i class="bi bi-truck"></i>
                        Entregas
                    </a>
                </li>

            </ul>
        </div>
        <div class="d-flex">
            <a class="btn btn-outline-primary me-2" href="<?php echo base_url('login/logout') ?>">
                <i class="bi bi-unlock"></i>
                sair
            </a>
        </div>
    </div>
</nav>