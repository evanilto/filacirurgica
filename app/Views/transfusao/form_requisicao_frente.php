<?= csrf_field() ?>
<?php $validation = \Config\Services::validation(); ?>

<form>
    <div class="mb-3">
        <label class="form-label">Nome do Paciente</label>
        <input type="text" name="nome" class="form-control" value="<?= esc($nome ?? '') ?>">
    </div>
    <!-- Outros campos -->
</form>

