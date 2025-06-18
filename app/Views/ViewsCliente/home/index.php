<?= $this->extend('Templates_user') ?>
<?= $this->section('content') ?>

<?php if(session()->getFlashdata('msg')): ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert" style="margin-top: 1rem;">
        <?= session()->getFlashdata('msg') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
<?php endif; ?>

<style>
    .row-3-cols {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .card-col {
        flex: 1 1 calc(33.333% - 1rem);
        max-width: calc(33.333% - 1rem);
    }
    .card-img-top {
        width: 100%;
        height: 300px;
        object-fit: cover;
        object-position: center center;
        border-radius: 0.25rem 0.25rem 0 0;
    }
</style>

<div id="produtos" class="container">

    <h2 class="border-bottom mt-3 border-2 border-primary">Produtos</h2>

    <?php 
    for($i = 0; $i < count($all_produtos); $i++) {
    ?>  
        <h3><?= esc($all_produtos[$i]['categorias_nome']) ?></h3> 
        
        <?php if(empty($all_produtos[$i]['produtos'])): ?>
            <div class="mb-3 pb-4 mb-sm-0">
                Ainda não há produtos cadastrados para esta categoria!
            </div>
        <?php else: ?>
            <div class="row-3-cols">
                <?php foreach($all_produtos[$i]['produtos'] as $produto): ?>
                    <div class="card-col mb-3 pb-4 mb-sm-0">
                        <div class="card h-100">
                            <img src="<?= base_url('assets/' . esc($produto->imgprodutos_link)) ?>" 
                                 class="card-img-top" alt="<?= esc($produto->produtos_nome) ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= esc($produto->produtos_nome) ?></h5>
                                <h5 class="card-title text-danger"><b>R$ <?= esc(number_format($produto->produtos_preco_venda, 2, ',', '.')) ?></b></h5>
                                <p class="card-text"><?= esc($produto->produtos_descricao) ?></p>
                                <p class="text-center mt-auto">
                                    <button type="button" 
                                            class="btn btn-primary btn-comprar" 
                                            data-produto-id="<?= esc($produto->produtos_id) ?>">
                                        Comprar <i class="bi bi-basket2-fill"></i>
                                    </button>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    <?php } ?>

</div>

<!-- Modal para escolher quantidade -->
<div class="modal fade" id="modalQuantidade" tabindex="-1" aria-labelledby="modalQuantidadeLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" action="<?= base_url('cliente/pedido/comprar') ?>">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalQuantidadeLabel">Escolha a quantidade</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="produto_id" id="produto_id" value="">
          <div class="mb-3">
            <label for="quantidade" class="form-label">Quantidade</label>
            <input type="number" name="quantidade" id="quantidade" min="1" value="1" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Adicionar ao Carrinho</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  document.querySelectorAll('.btn-comprar').forEach(button => {
    button.addEventListener('click', function() {
      const produtoId = this.getAttribute('data-produto-id');
      document.getElementById('produto_id').value = produtoId;
      const modal = new bootstrap.Modal(document.getElementById('modalQuantidade'));
      modal.show();
    });
  });
</script>

<?= $this->endSection() ?>
