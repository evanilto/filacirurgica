<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('/', function ($routes) {
    $routes->get('', 'Home');
    $routes->get('home', 'Home');
    $routes->get('home_index', 'Home::index_home');
    $routes->post('home/login', 'Home::login');
    $routes->get('home/logout', 'Home::logout');
    $routes->get('testeconexao/(:any)', 'Testeconexao::index/$1');
});

$routes->group('listaespera', ['filter' => 'auth'], function ($routes) {
    $routes->get('consultar', 'ListaEspera::consultarListaEspera');
    $routes->add('exibir', 'ListaEspera::exibirListaEspera');
    $routes->add('mostrarlista', 'ListaEspera::mostrarListaEsperaSalva');
    $routes->get('consultaritemlista/(:num)', 'ListaEspera::consultarItemLista/$1');
    $routes->get('consultaritemlista/(:num)/(:num)', 'ListaEspera::consultarItemLista/$1/$2');
    //$routes->get('consultarpacienteexcluido/(:num)', 'ListaEspera::consultarPacienteExcluido/$1');
    $routes->get('carregaaside/(:num)', 'ListaEspera::getDetailsAside/$1');
    $routes->get('carregaaside/(:num)/(:any)', 'ListaEspera::getDetailsAside/$1/$2');
    $routes->get('carregaaside/(:num)/(:any)/(:any)', 'ListaEspera::getDetailsAside/$1/$2/$3');
    $routes->get('carregadadosmodal', 'ListaEspera::getDadosModal');
    $routes->post('verificapacientenalista', 'ListaEspera::verificaPacienteNaLista');
    $routes->post('verificaequipamentos', 'ListaEspera::verificaUsoEquipamentos');
    $routes->post('getnomepac/(:num)', 'ListaEspera::getNomePaciente/$1');
    $routes->get('incluirpaciente', 'ListaEspera::incluirPacienteNaLista');
    $routes->post('incluir', 'ListaEspera::incluir');
    //$routes->get('editarlista/(:num)/(:num)', 'ListaEspera::editarLista/$1/$2');
    $routes->get('editarlista/(:num)', 'ListaEspera::editarLista/$1');
    $routes->post('editar', 'ListaEspera::editar');
    $routes->get('excluirpaciente/(:num)', 'ListaEspera::excluirPaciente/$1');
    $routes->post('excluir/', 'ListaEspera::excluirPacienteDaLista');
    $routes->get('enviarmapa/(:num)', 'ListaEspera::enviarMapa/$1');
    $routes->post('enviar', 'ListaEspera::enviar');
    $routes->post('getlista', 'ListaEspera::getListaPaciente');
    $routes->get('situacaocirurgica', 'ListaEspera::consultarSituacaoCirurgica');
    $routes->add('exibirsituacao', 'ListaEspera::exibirSituacaoCirurgica');
    $routes->get('consultarexcluidos', 'ListaEspera::consultarExcluidos');
    $routes->add('exibirexcluidos', 'ListaEspera::exibirExcluidos');
    $routes->get('recuperarexcluido/(:num)', 'ListaEspera::recuperarPaciente/$1');
    $routes->post('recuperar', 'ListaEspera::recuperar');
    $routes->post('verpacientenafrente', 'ListaEspera::verPacienteNaFrente');
    $routes->post('sincronizaraghux/(:num)', 'ListaEspera::sincronizar/$1');
});

$routes->group('mapacirurgico', ['filter' => 'auth'], function ($routes) {
    $routes->get('consultar', 'MapaCirurgico::consultarMapaCirurgico');
    $routes->add('exibir', 'MapaCirurgico::exibirMapaCirurgico');
    $routes->add('mostrarmapa', 'MapaCirurgico::mostrarMapaCirurgicoSalvo');
    $routes->get('atualizarcirurgia/(:num)', 'MapaCirurgico::atualizarCirurgia/$1');
    $routes->get('consultarcirurgia/(:num)', 'MapaCirurgico::consultarCirurgia/$1');
    $routes->get('consultarcirurgia/(:num)/(:any)', 'MapaCirurgico::consultarCirurgia/$1/$2');
    $routes->get('consultarcirurgiaemaprovacao/(:num)', 'MapaCirurgico::consultarCirurgiaEmAprovacao/$1');
    $routes->post('atualizar', 'MapaCirurgico::atualizar');
    $routes->post('tratareventocirurgico', 'MapaCirurgico::tratarEventoCirurgico');
    $routes->get('atualizarhorarioscirurgia/(:num)', 'MapaCirurgico::atualizarHorariosCirurgia/$1');
    $routes->post('atualizarhorarios', 'MapaCirurgico::atualizarHorarios');
    $routes->get('trocarpaciente', 'MapaCirurgico::trocarPaciente');
    $routes->post('trocar', 'MapaCirurgico::trocar');
    $routes->get('urgencia', 'MapaCirurgico::incluirUrgencia');
    $routes->post('incluir', 'MapaCirurgico::incluir');
    #$routes->get('carregaaside/(:num)', 'MapaCirurgico::getDetailsAside/$1');
    $routes->add('exibirhistorico/(:num)', 'MapaCirurgico::exibirHistorico/$1');
    $routes->get('suspendercirurgia/(:num)', 'MapaCirurgico::SuspenderCirurgia/$1');
    $routes->get('suspendercirurgia/(:num)/(:any)', 'MapaCirurgico::SuspenderCirurgia/$1/$2');
    $routes->post('suspender/', 'MapaCirurgico::suspender');
    $routes->get('avaliarcirurgias', 'MapaCirurgico::avaliarCirurgias');
    $routes->add('exibircirurgiacomhemocomps', 'MapaCirurgico::exibirCirurgiasComHemocomponentes');
    $routes->get('reservarhemocomponente/(:num)', 'MapaCirurgico::reservarHemocomponente/$1');
    $routes->post('confirmarreserva', 'MapaCirurgico::confirmarReserva');
    $routes->add('exibircirurgiasemaprovacao', 'MapaCirurgico::exibirCirurgiasEmAprovacao');
    $routes->get('aprovarcirurgia/(:num)/(:num)', 'MapaCirurgico::aprovarCirurgia/$1/$2');
    $routes->get('desaprovarcirurgia/(:num)/(:num)', 'MapaCirurgico::desaprovarCirurgia/$1/$2');
    $routes->get('vercirurgiasemaprovacao', 'MapaCirurgico::verCirurgiasEmAprovacao');
    $routes->post('verificacirurgiasemaprovacao', 'MapaCirurgico::verificaCirurgiasEmAprovacao');
    $routes->post('verificacirurgiascomhemocomponentes', 'MapaCirurgico::verificaCirurgiasComHemocomponentes');
});

$routes->group('usuarios', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'Usuarios');
    $routes->post('', 'Usuarios::create');
    $routes->get('list', 'Usuarios::getUsuarios');
    $routes->get('(:num)', 'Usuarios::show/$1');
    $routes->patch('(:num)', 'Usuarios::update/$1');
    $routes->delete('(:num)', 'Usuarios::delete/$1');
    $routes->get('incluir', 'Usuarios::incluir_usuario');
    $routes->get('editar/(:num)', 'Usuarios::editar_usuario/$1');
    $routes->post('incluir', 'Usuarios::incluir');
    $routes->post('editar/(:num)', 'Usuarios::editar/$1');
    $routes->get('excluir/(:num)', 'Usuarios::excluir/$1');
    $routes->get('listar', 'Usuarios::listar');
    $routes->get('carregarPagina/(:segment)', 'Usuarios::carregarPagina/$1');
});

$routes->group('filas', ['filter' => 'auth'], function ($routes) {
    $routes->get('incluir', 'Filas::incluir_fila');
    $routes->post('incluir', 'Filas::incluir');
    $routes->get('editar/(:num)', 'Filas::editar_fila/$1');
    $routes->post('editar/(:num)', 'Filas::editar/$1');
    $routes->get('listar', 'Filas::listar');
});

$routes->group('equipamentos', ['filter' => 'auth'], function ($routes) {
    $routes->get('incluir', 'Equipamentos::incluir_equipamento');
    $routes->post('incluir', 'Equipamentos::incluir');
    $routes->get('editar/(:num)', 'Equipamentos::editar_equipamento/$1');
    $routes->post('editar/(:num)', 'Equipamentos::editar/$1');
    $routes->get('listar', 'Equipamentos::listar');
});

$routes->group('relatorios', ['filter' => 'auth'], function ($routes) {
    $routes->get('agendas', 'Agendas::consultarAgendas');
    $routes->post('consultar', 'Agendas::consultar');
    $routes->get('imprimiragendas', 'Agendas::imprimirAgendas');
    $routes->get('movimentacoessetor', 'Prontuarios::consultarMovimentacoesSetor');
    $routes->post('qtdmovimentacoessetor', 'Prontuarios::qtdMovimentacoesSetor');
    $routes->get('prontuariosretidos', 'Prontuarios::consultarProntuariosRetidos');
    $routes->post('prontuariosretidos', 'Prontuarios::listarProntuariosRetidos');
    $routes->get('imprimirprontuariosretidos', 'Prontuarios::imprimirProntuariosRetidos');

});

/* $routes->get('inserir-paciente', 'PacientesController::inserir_paciente');
 */