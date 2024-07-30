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

$routes->group('listaespera', function ($routes) {
    $routes->get('consultar', 'ListaEspera::consultarListaEspera');
    $routes->add('exibir', 'ListaEspera::exibirListaEspera');
    $routes->get('carregaaside/(:num)/(:num)', 'ListaEspera::getDetailsAside/$1/$2');
    $routes->post('getnomepac/(:num)', 'ListaEspera::getNomePaciente/$1');
    $routes->get('incluirpaciente', 'ListaEspera::incluirPacienteNaLista');
    $routes->post('incluir', 'ListaEspera::incluir');
    $routes->get('editarlista/(:num)', 'ListaEspera::editarLista/$1');
    $routes->post('editar', 'ListaEspera::editar');
    $routes->get('excluir/(:num)', 'ListaEspera::excluirPacienteDaLista/$1');
    $routes->get('enviarmapa/(:num)', 'ListaEspera::enviarMapa/$1');
    $routes->post('enviar', 'ListaEspera::enviar');
});

$routes->group('mapacirurgico', function ($routes) {
    $routes->get('consultar', 'MapaCirurgico::consultarMapaCirurgico');
    $routes->add('exibir', 'MapaCirurgico::exibirMapaCirurgico');
    $routes->get('atualizarcirurgia/(:num)', 'MapaCirurgico::atualizarCirurgia/$1');
    $routes->post('atualizar', 'MapaCirurgico::atualizar');
    #$routes->get('carregaaside/(:num)', 'MapaCirurgico::getDetailsAside/$1');
});

$routes->group('usuarios', function ($routes) {
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

$routes->group('relatorios', function ($routes) {
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