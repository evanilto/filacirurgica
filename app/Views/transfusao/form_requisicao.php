<?= csrf_field() ?>
<?php $validation = \Config\Services::validation(); ?>

<style>
    /* Torna as abas com cantos arredondados e contorno mais visível */
    

    .tabs-transfusao-form .nav {
            background-color: #f4f4f4;
    }

    .tabs-transfusao-form .nav-tabs .nav-link {
        background-color: #faf6f6ff;
        color: black;
        font-weight: 500;
        border-color: #dee2e6 #dee2e6 #fff;
        box-shadow: 0 -2px 6px rgba(0, 0, 0, 0.05);

    }
    .tabs-transfusao-form .nav-tabs .nav-link.active {
        background-color: #fff;
        color: #1e8052ff;
        font-weight: bold;
        border-color: #dee2e6 #dee2e6 #fff;
        box-shadow: 0 -2px 6px rgba(0, 0, 0, 0.05);

    }

    /* Borda do conteúdo das abas */
    .tabs-transfusao-form .tab-content {
        border: 2px solid #dee2e6;
        border-top: none;
        border-bottom-left-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
        background-color: #fff;
        padding: 1.5rem;
    }


</style>


<div class="container mt-4 mb-4 tabs-transfusao-form">
    <ul class="nav nav-tabs" id="formTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="requisicao-tab" data-bs-toggle="tab" data-bs-target="#requisicao" type="button" role="tab" aria-controls="requisicao" aria-selected="true">
                Requisição Transfusional
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="atendimento-tab" data-bs-toggle="tab" data-bs-target="#atendimento" type="button" role="tab" aria-controls="atendimento" aria-selected="false">
                Testes Pré-Transfusionais
            </button>
        </li>
    </ul>

    <div class="tab-content border border-top-0 p-4" id="formTabsContent">
        <!-- Aba 1: Requisição Transfusional -->
        <div class="tab-pane fade show active" id="requisicao" role="tabpanel" aria-labelledby="requisicao-tab">
            <?php include(APPPATH . 'Views/transfusao/form_requisicao_frente.php'); ?>
        </div>

        <!-- Aba 2: Atendimento da Requisição -->
        <div class="tab-pane fade" id="atendimento" role="tabpanel" aria-labelledby="atendimento-tab">
            <?php include(APPPATH . 'Views/transfusao/form_requisicao_verso.php'); ?>
        </div>
    </div>
    
</div>
