<?php use App\Libraries\HUAP_Functions; ?>
<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-primary rounded menu-lateral">
    <ul class="nav ul-first navbar-nav flex-column">
        <?php if(HUAP_Functions::tem_permissao('listaespera') || HUAP_Functions::tem_permissao('exames')){ ?>
        <li>
            <a href="#listaespera" class="nav-link text-white p-2" data-bs-toggle="collapse" aria-expanded="false">
                <i class="fa-solid fa-plus toggle-icon"></i> Fila
            </a>
            <div class="collapse" id="listaespera">
                <ul class="nav flex-column submenu-2">
                    <?php if(HUAP_Functions::tem_permissao('listaespera-incluir') || HUAP_Functions::tem_permissao('exames')) { ?>
                    <li>
                        <a href="<?= base_url('listaespera/incluirpaciente') ?>" class="nav-link text-white p-2" aria-current="page">
                            <i class="fa-solid fa-user-nurse"></i> Incluir
                        </a>
                    </li>
                    <?php } ?>
                    <?php if(HUAP_Functions::tem_permissao('listaespera-consultar') || HUAP_Functions::tem_permissao('exames')) { ?>
                    <li>
                        <a href="<?= base_url('listaespera/consultar') ?>" class="nav-link text-white p-2" aria-current="page">
                            <i class="fa-solid fa-user-nurse"></i> Consultar
                        </a>
                    </li>
                    <?php } ?>
                    <?php if(HUAP_Functions::tem_permissao('listaespera-recuperar') || HUAP_Functions::tem_permissao('exames')) { ?>
                    <li>
                        <a href="<?= base_url('listaespera/consultarexcluidos') ?>" class="nav-link text-white p-2" aria-current="page">
                            <i class="fa-solid fa-user-nurse"></i> Recuperar Paciente
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </li>
        <?php } ?>
    </ul>
    <ul class="nav navbar-nav flex-column">
        <?php if(HUAP_Functions::tem_permissao('mapacirurgico') || HUAP_Functions::tem_permissao('exames')) { ?>
        <li>
                <a href="#mapa" class="nav-link text-white p-2" data-bs-toggle="collapse" aria-expanded="false">
                    <i class="fa-solid fa-plus toggle-icon"></i> Mapa
                </a>
                <div class="collapse" id="mapa">
                    <ul class="nav flex-column submenu-2">
                        <?php if(HUAP_Functions::tem_permissao('mapacirurgico-consultar') || HUAP_Functions::tem_permissao('exames')) { ?>
                        <li>
                            <a href="<?= base_url('mapacirurgico/consultar') ?>" class="nav-link text-white p-2" aria-current="page">
                                <i class="fa-solid fa-user-nurse"></i> Consultar
                            </a>
                        </li>
                        <?php } ?>
                        <?php if(HUAP_Functions::tem_permissao('mapacirurgico-incluirurgencia')) { ?>
                        <li>
                            <a href="<?= base_url('mapacirurgico/urgencia') ?>" class="nav-link text-white p-2" aria-current="page">
                                <i class="fa-solid fa-user-nurse"></i> Incluir Urgência
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </li>
        <?php } ?>
    </ul>
    <ul class="nav navbar-nav flex-column">
        <?php if(
            HUAP_Functions::tem_permissao('bcosangue-reservarhemocomponente') ||
            HUAP_Functions::tem_permissao('transfusao-requisitar') ||
            HUAP_Functions::tem_permissao('transfusao-atender')
        ) { ?>
        <li>
            <a href="#bcosangue" class="nav-link text-white p-2" data-bs-toggle="collapse" aria-expanded="false">
                <i class="fa-solid fa-plus toggle-icon"></i> Banco de Sangue
            </a>
            <div class="collapse" id="bcosangue">
                <ul class="nav flex-column submenu-2">

                    <?php if(HUAP_Functions::tem_permissao('bcosangue-reservarhemocomponente')) { ?>
                    <li>
                        <a href="<?= base_url('mapacirurgico/consultarcirurgiacomhemocomps') ?>" class="link-aguarde nav-link text-white p-2" aria-current="page">
                            <i class="fa-solid fa-user-nurse"></i> Consultar Hemocomponentes
                        </a>
                    </li>
                    <?php } ?>

                    <?php if(
                        HUAP_Functions::tem_permissao('transfusao-requisitar') ||
                        HUAP_Functions::tem_permissao('transfusao-atender')
                    ) { ?>
                    <li>
                        <a href="#submenuTransfusao" class="nav-link text-white p-2" data-bs-toggle="collapse" aria-expanded="false">
                            <i class="fa-solid fa-plus toggle-icon"></i> Transfusão
                        </a>
                        <div class="collapse" id="submenuTransfusao">
                            <ul class="nav flex-column submenu-3">
                                <?php if(HUAP_Functions::tem_permissao('transfusao-requisitar')) { ?>
                                    <li>
                                        <a href="<?= base_url('transfusao/requisitar') ?>" class="link-aguarde nav-link text-white p-2" aria-current="page">
                                            <i class="fa-solid fa-user-nurse"></i> Nova Requisição
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if(HUAP_Functions::tem_permissao('transfusao-atender')) { ?>
                                    <li>
                                        <a href="<?= base_url('transfusao/consultar') ?>" class="link-aguarde nav-link text-white p-2" aria-current="page">
                                            <i class="fa-solid fa-user-nurse"></i> Consultar Requisições
                                        </a>
                                    </li>
                                <?php } ?>
                                <!-- <-?php if(HUAP_Functions::tem_permissao('transfusao-requisitar')) { ?>
                                    <li>
                                        <a href="<-= base_url('transfusao/emitirtcle') ?>" class="link-aguarde nav-link text-white p-2" aria-current="page">
                                            <i class="fa-solid fa-user-nurse"></i> Emitir TCLE
                                        </a>
                                    </li>
                                <-?php } ?> -->
                            </ul>
                        </div>
                    </li>
                    <?php } ?>

                </ul>
            </div>
        </li>
        <?php } ?>
    </ul>
    <ul class="nav navbar-nav flex-column">
        <?php if(HUAP_Functions::tem_permissao('relatorios')) { ?>
        <li>
            <a href="#relatorios" class="nav-link text-white p-2" data-bs-toggle="collapse" aria-expanded="false">
                <i class="fa-solid fa-plus toggle-icon"></i> Relatórios
            </a>
            <div class="collapse" id="relatorios">
                <ul class="nav flex-column submenu-2">
                    <?php if(HUAP_Functions::tem_permissao('relatorios-potencialcontaminacao')) { ?>
                    <li>
                        <a href="<?= base_url('relatorios/potencialcontaminacao') ?>" class="nav-link text-white p-2" aria-current="page">
                            <i class="fa-solid fa-user-nurse"></i> Cirurgias/PDT
                        </a>
                    <?php } ?>
                    </li>
                </ul>
                <!-- <ul class="nav flex-column submenu-2">
                    <li>
                    <a href="<-?= base_url('relatorios/prontuariosretidos') ?>" class="nav-link text-white p-2 enabled" tabindex="-1" aria-disabled="false">
                            <i class="fa-solid fa-user-nurse"></i> Prontuários Retidos
                        </a>
                    </li>
                </ul>
                <ul class="nav flex-column submenu-2">
                    <li>
                        <a href="<-?= base_url('relatorios/movimentacoessetor') ?>" class="nav-link text-white p-2" aria-current="page">
                            <i class="fa-solid fa-user-nurse"></i> Movimentações entre Setores
                        </a>
                    </li>
                </ul> -->
            </div>
        </li>
        <?php } ?>
    </ul>
    <ul class="nav navbar-nav flex-column">
        <?php if(HUAP_Functions::tem_permissao('cadastros')) { ?>
            <li>
                <a href="#cadastros" class="nav-link text-white p-2" data-bs-toggle="collapse" aria-expanded="false">
                    <i class="fa-solid fa-plus toggle-icon"></i> Cadastros
                </a>
                <div class="collapse" id="cadastros">
                    <ul class="nav flex-column submenu-2">
                        <li>
                            <a href="#filas" class="nav-link text-white p-2" data-bs-toggle="collapse" aria-expanded="false">
                                <i class="fa-solid fa-plus toggle-icon"></i> Filas
                            </a>
                            <div class="collapse" id="filas">
                                <ul class="nav flex-column submenu-3">
                                <?php if(HUAP_Functions::tem_permissao('cadastros-incluir')) { ?>
                                    <li>
                                        <a href="<?= base_url('filas/incluir') ?>" class="nav-link text-white p-2" aria-current="page">
                                            <i class="fa-solid fa-user-nurse"></i> Incluir
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if(HUAP_Functions::tem_permissao('cadastros-consultar')) { ?>
                                    <li>
                                        <a href="<?= base_url('filas/listar') ?>" class="nav-link text-white p-2" aria-current="page">
                                            <i class="fa-solid fa-user-nurse"></i> Listar
                                        </a>
                                    </li>
                                <?php } ?>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="#usuarios" class="nav-link text-white p-2" data-bs-toggle="collapse" aria-expanded="false">
                                <i class="fa-solid fa-plus toggle-icon"></i> Usuários
                            </a>
                            <div class="collapse" id="usuarios">
                                <ul class="nav flex-column submenu-3">
                                <?php if(HUAP_Functions::tem_permissao('cadastros-incluir')) { ?>
                                    <li>
                                        <a href="<?= base_url('usuarios/incluir') ?>" class="nav-link text-white p-2" aria-current="page">
                                            <i class="fa-solid fa-user-nurse"></i> Incluir
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if(HUAP_Functions::tem_permissao('cadastros-consultar')) { ?>
                                    <li>
                                        <a href="<?= base_url('usuarios/listar') ?>" class="nav-link text-white p-2" aria-current="page">
                                            <i class="fa-solid fa-user-nurse"></i> Listar
                                        </a>
                                    </li>
                                <?php } ?>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="#equipamentos" class="nav-link text-white p-2" data-bs-toggle="collapse" aria-expanded="false">
                                <i class="fa-solid fa-plus toggle-icon"></i> Equipamentos
                            </a>
                            <div class="collapse" id="equipamentos">
                                <ul class="nav flex-column submenu-3">
                                <?php if(HUAP_Functions::tem_permissao('cadastros-incluir')) { ?>
                                    <li>
                                        <a href="<?= base_url('equipamentos/incluir') ?>" class="nav-link text-white p-2" aria-current="page">
                                            <i class="fa-solid fa-user-nurse"></i> Incluir
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if(HUAP_Functions::tem_permissao('cadastros-consultar')) { ?>
                                    <li>
                                        <a href="<?= base_url('equipamentos/listar') ?>" class="nav-link text-white p-2" aria-current="page">
                                            <i class="fa-solid fa-user-nurse"></i> Listar
                                        </a>
                                    </li>
                                <?php } ?>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
        <?php } ?>
    </ul>
    <ul class="nav navbar-nav flex-column">
        <?php if(!HUAP_Functions::tem_permissao('painel-cirurgico-diario')) { ?>
            <li>
                <a href="<?= base_url('listaespera/situacaocirurgica') ?>" class="nav-link text-white p-2" aria-current="page">
                    <i class="fa-solid fa-user-nurse"></i> Situação Cirúrgica/PDT
                </a>
            </li>
        <?php } ?>
    </ul>
    <ul class="nav navbar-nav flex-column">
        <?php if(HUAP_Functions::tem_permissao('painel-cirurgico-diario')) { ?>
            <li>
                <a href="<?= base_url('mapacirurgico/exibirpaineldiario') ?>" class="nav-link text-white p-2" aria-current="page">
                    <i class="fa-solid fa-user-nurse"></i> Painel Cirúrgico Diário
                </a>
            </li>
        <?php } ?>
    </ul>
    <ul class="nav navbar-nav flex-column">
        <li>
            <a href="<?= base_url('home_index') ?>" class="nav-link text-white p-2" aria-current="page">
            <i class="fa-solid fa-backward-step"></i> Início
            </a>
        </li>
    </ul>
</div>
<script>
    $(document).ready(function() {
        // Atualiza ícones ao abrir submenus
        $('.collapse').on('show.bs.collapse', function() {
            // Muda o ícone do link imediatamente acima para '-'
            $(this).prev('.nav-link').find('.toggle-icon').removeClass('fa-plus').addClass('fa-minus');
        });

        // Atualiza ícones ao fechar submenus
        $('.collapse').on('hide.bs.collapse', function(e) {
            var $this = $(this);
            // Aplica a mudança de ícone após o colapso ser totalmente realizado
            setTimeout(() => {
                if (!$this.hasClass('show')) {
                    $this.prev('.nav-link').find('.toggle-icon').removeClass('fa-minus').addClass('fa-plus');
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
                    $this.prev('.nav-link').find('.toggle-icon').removeClass('fa-minus').addClass('fa-plus');
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






