<?= csrf_field() ?>
<?php $validation = \Config\Services::validation(); ?>

<div class="container mt-4">
    <h4>Formulário Transfusional</h4>

    <!-- Nav Tabs -->
    <ul class="nav nav-tabs mt-3" id="formTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="frente-tab" data-bs-toggle="tab" data-bs-target="#frente" type="button" role="tab">
                Frente
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="verso-tab" data-bs-toggle="tab" data-bs-target="#verso" type="button" role="tab">
                Verso
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content border rounded-bottom p-3 bg-white" id="formTabsContent">
    <div class="tab-pane fade show active" id="frente" role="tabpanel" aria-labelledby="frente-tab">
        <?= view('layouts/sub_content', ['view' => 'transfusao/form_requisicao_frente', 'data' => $data ?? []]); ?>
    </div>
    <div class="tab-pane fade" id="verso" role="tabpanel" aria-labelledby="verso-tab">
        <?= view('layouts/sub_content', ['view' => 'transfusao/form_requisicao_verso', 'data' => $data ?? []]); ?>
    </div>
</div>

</div>

<?= $this->endSection() ?>
