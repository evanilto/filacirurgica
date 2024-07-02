<?php use App\Libraries\HUAP_Functions; ?>
<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-primary rounded menu-lateral">
    <ul class="nav ul-first flex-column">
        <?php if(true) { ?>
            <li>
                <a href="#listaespera" class="nav-link text-white p-2" data-bs-toggle="collapse" aria-expanded="false">
                    <i class="fa-solid fa-chevron-right toggle-icon"></i> Lista de Espera
                </a>
                <div class="collapse" id="listaespera">
                    <ul class="nav flex-column submenu-2">
                        <li>
                            <a href="<?= base_url('listaespera/ncluir') ?>" class="nav-link text-white p-2" aria-current="page">
                                <i class="fa-solid fa-user-nurse"></i> Incluir
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('listaespera/consultar') ?>" class="nav-link text-white p-2" aria-current="page">
                                <i class="fa-solid fa-user-nurse"></i> Consultar
                            </a>
                        </li>
                        <li>
                            <a href="#consultar" class="nav-link text-white p-2" data-bs-toggle="collapse" aria-expanded="false">
                                <i class="fa-solid fa-chevron-right toggle-icon"></i> Pesquisar
                            </a>
                            <div class="collapse" id="consultar">
                                <ul class="nav flex-column submenu-3">
                                    <li>
                                        <a href="<?= base_url('prontuarios/localizadosnosetor') ?>" class="nav-link link-aguarde text-white p-2" aria-current="page">
                                            <i class="fa-solid fa-user-nurse"></i> Localizados no Setor
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('prontuarios/enviadosparaosetor') ?>" class="nav-link link-aguarde text-white p-2" aria-current="page">
                                            <i class="fa-solid fa-user-nurse"></i> Encaminhados para o Setor
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="#tramitar" class="nav-link text-white p-2" data-bs-toggle="collapse" aria-expanded="false">
                                <i class="fa-solid fa-chevron-right toggle-icon"></i> Tramitar
                            </a>
                            <div class="collapse" id="tramitar">
                                <ul class="nav flex-column submenu-3">
                                    <li>
                                        <a href="<?= base_url('prontuarios/tramitar') ?>" class="nav-link text-white p-2" aria-current="page">
                                            <i class="fa-solid fa-user-nurse"></i> Enviar
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('prontuarios/receber') ?>" class="nav-link text-white p-2" aria-current="page">
                                            <i class="fa-solid fa-user-nurse"></i> Receber
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('prontuarios/recuperar') ?>" class="nav-link link-aguarde text-white p-2" aria-current="page">
                                            <i class="fa-solid fa-user-nurse"></i> Recuperar
                                        </a>
                                    </li>
                                    <?php if(true) { ?>
                                        <li>
                                            <a href="<?= base_url('prontuarios/resgatar') ?>" class="nav-link text-white p-2" aria-current="page">
                                                <i class="fa-solid fa-user-nurse"></i> Resgatar
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="#solicitacoes" class="nav-link text-white p-2" data-bs-toggle="collapse" aria-expanded="false">
                                <i class="fa-solid fa-chevron-right toggle-icon"></i> Solicitações
                            </a>
                            <div class="collapse" id="solicitacoes">
                                <ul class="nav flex-column submenu-3">
                                    <li>
                                        <a href="<?= base_url('prontuarios/solicitar') ?>" class="nav-link text-white p-2" aria-current="page">
                                            <i class="fa-solid fa-user-nurse"></i> Solicitar
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('prontuarios/solicitacoesdosetor') ?>" class="nav-link text-white p-2" aria-current="page">
                                            <i class="fa-solid fa-user-nurse"></i> Solicitacoes do Setor
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('prontuarios/solicitacoesexternas') ?>" class="nav-link text-white p-2" aria-current="page">
                                            <i class="fa-solid fa-user-nurse"></i> Solicitações Externas
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
        <?php } ?>
    </ul>
    <ul class="nav flex-column">
        <?php if(true) { ?>
            <li>
                <a href="#agendas" class="nav-link text-white p-2" data-bs-toggle="collapse" aria-expanded="false">
                    <i class="fa-solid fa-chevron-right toggle-icon"></i> Mapa Cirúrgico
                </a>
                <div class="collapse" id="agendas">
                    <ul class="nav flex-column submenu-2">
                        <li>
                            <a href="<?= base_url('agendas/recuperaragendas') ?>" class="nav-link text-white p-2" aria-current="page">
                                <i class="fa-solid fa-user-nurse"></i> Buscar
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        <?php } ?>
    </ul>
    <ul class="nav flex-column">
        <?php if(true) { ?>
            <li>
                <a href="#relatorios" class="nav-link text-white p-2" data-bs-toggle="collapse" aria-expanded="false">
                    <i class="fa-solid fa-chevron-right toggle-icon"></i> Relatórios
                </a>
                <div class="collapse" id="relatorios">
                    <ul class="nav flex-column submenu-2">
                        <li>
                            <a href="<?= base_url('relatorios/agendas') ?>" class="nav-link text-white p-2" aria-current="page">
                                <i class="fa-solid fa-user-nurse"></i> Agendas
                            </a>
                        </li>
                    </ul>
                    <ul class="nav flex-column submenu-2">
                        <li>
                        <a href="<?= base_url('relatorios/prontuariosretidos') ?>" class="nav-link text-white p-2 enabled" tabindex="-1" aria-disabled="false">
                                <i class="fa-solid fa-user-nurse"></i> Prontuários Retidos
                            </a>
                        </li>
                    </ul>
                    <ul class="nav flex-column submenu-2">
                        <li>
                            <a href="<?= base_url('relatorios/movimentacoessetor') ?>" class="nav-link text-white p-2" aria-current="page">
                                <i class="fa-solid fa-user-nurse"></i> Movimentações entre Setores
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        <?php } ?>
    </ul>
    <ul class="nav flex-column">
        <?php if(true) { ?>
            <li>
                <a href="#cadastros" class="nav-link text-white p-2" data-bs-toggle="collapse" aria-expanded="false">
                    <i class="fa-solid fa-chevron-right toggle-icon"></i> Cadastros
                </a>
                <div class="collapse" id="cadastros">
                    <ul class="nav flex-column submenu-2">
                        <li>
                            <a href="#setores" class="nav-link text-white p-2" data-bs-toggle="collapse" aria-expanded="false">
                                <i class="fa-solid fa-chevron-right toggle-icon"></i> Setores
                            </a>
                            <div class="collapse" id="setores">
                                <ul class="nav flex-column submenu-3">
                                    <li>
                                        <a href="<?= base_url('setores/incluir') ?>" class="nav-link text-white p-2" aria-current="page">
                                            <i class="fa-solid fa-user-nurse"></i> Incluir
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('setores/listar') ?>" class="nav-link text-white p-2" aria-current="page">
                                            <i class="fa-solid fa-user-nurse"></i> Listar
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="#usuarios" class="nav-link text-white p-2" data-bs-toggle="collapse" aria-expanded="false">
                                <i class="fa-solid fa-chevron-right toggle-icon"></i> Usuários
                            </a>
                            <div class="collapse" id="usuarios">
                                <ul class="nav flex-column submenu-3">
                                    <li>
                                        <a href="<?= base_url('usuarios/incluir') ?>" class="nav-link text-white p-2" aria-current="page">
                                            <i class="fa-solid fa-user-nurse"></i> Incluir
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('usuarios/listar') ?>" class="nav-link text-white p-2" aria-current="page">
                                            <i class="fa-solid fa-user-nurse"></i> Listar
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
        <?php } ?>
    </ul>
    <ul class="nav flex-column">
        <li>
            <a href="<?= base_url('home_index') ?>" class="nav-link text-white p-2" aria-current="page">
                <i class="fa-solid fa-user-nurse"></i> Início
            </a>
        </li>
    </ul>
</div>
<script>
    $(document).ready(function() {
        // Atualiza ícones ao abrir submenus
        $('.collapse').on('show.bs.collapse', function() {
            // Muda o ícone do link imediatamente acima para '-'
            $(this).prev('.nav-link').find('.toggle-icon').removeClass('fa-chevron-right').addClass('fa-chevron-down');
        });

        // Atualiza ícones ao fechar submenus
        $('.collapse').on('hide.bs.collapse', function(e) {
            var $this = $(this);
            // Aplica a mudança de ícone após o colapso ser totalmente realizado
            setTimeout(() => {
                if (!$this.hasClass('show')) {
                    $this.prev('.nav-link').find('.toggle-icon').removeClass('fa-chevron-down').addClass('fa-chevron-right');
                }
            }, 250);
        });

        // Ajustar ícones quando o submenu é completamente recolhido
        $('.collapse').on('hidden.bs.collapse', function(e) {
            var $this = $(this);
            var $parentCollapse = $this.parent().closest('.collapse');

            // Verifica se é o collapse atual que está sendo fechado, não apenas um interno
            if ($(e.target).is($this)) {
                if ($parentCollapse.length === 0 || $parentCollapse.find('.collapse.show').length === 0) {
                    $this.prev('.nav-link').find('.toggle-icon').removeClass('fa-chevron-down').addClass('fa-chevron-right');
                }
            }
        });

        $('.link-aguarde').on('click', function(e) {
            e.preventDefault();  // Impede a navegação imediata
            $('#janelaAguarde').show();

            // Simula um delay de carregamento e depois redireciona
            setTimeout(function() {
                window.location.href = $(e.target).attr('href');  // Redireciona para o URL do link
            }, 2000);  // Ajuste o tempo conforme necessário
        });
    });
</script>






