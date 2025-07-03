<?= csrf_field() ?>
<?php $validation = \Config\Services::validation(); ?>

<form>
    <div class="mb-3">
        <label class="form-label">Observações</label>
        <textarea name="observacoes" class="form-control"><?= esc($observacoes ?? '') ?></textarea>
    </div>
    <!-- Outros campos -->
</form>


