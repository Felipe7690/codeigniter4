<?= $this->extend('Templates_admin') ?>
<?= $this->section('content') ?>

<div class="container pt-4 pb-5 bg-light">
    <h2 class="border-bottom border-2 border-primary mb-4">
        <?= isset($form_label) ? $form_label : ucfirst($form) ?> Funcionário
    </h2>

    <form action="<?= base_url('funcionarios/' . ($form == 'editar' ? 'update/' . $funcionario->funcionarios_id : 'store')) ?>" method="post">

        <div class="mb-3">
            <label for="funcionarios_usuarios_id" class="form-label">Usuário</label>
            <select name="funcionarios_usuarios_id" id="funcionarios_usuarios_id" class="form-select" required>
                <option value="">Selecione o usuário</option>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= $usuario->usuarios_id ?>"
                        <?= (isset($funcionario) && $funcionario->funcionarios_usuarios_id == $usuario->usuarios_id) ? 'selected' : '' ?>>
                        <?= esc($usuario->usuarios_nome) ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="funcionarios_cargo" class="form-label">Cargo</label>
            <input type="text" class="form-control" name="funcionarios_cargo" id="funcionarios_cargo"
                   value="<?= isset($funcionario) ? esc($funcionario->funcionarios_cargo) : '' ?>" required>
        </div>

        <div class="mb-3">
            <label for="funcionarios_salario" class="form-label">Salário</label>
            <input type="number" step="0.01" class="form-control" name="funcionarios_salario" id="funcionarios_salario"
                   value="<?= isset($funcionario) ? esc($funcionario->funcionarios_salario) : '' ?>" required>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-success">
                <?= isset($form_label) ? $form_label : ucfirst($form) ?> <i class="bi bi-floppy"></i>
            </button>
            <a href="<?= base_url('funcionarios') ?>" class="btn btn-secondary ms-2">
                Cancelar <i class="bi bi-x-circle"></i>
            </a>
        </div>

    </form>
</div>

<?= $this->endSection() ?>
