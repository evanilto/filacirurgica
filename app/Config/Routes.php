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
    $routes->get('movimentacoes', 'Prontuarios::consultarMovimentacoes');
    $routes->post('historico', 'Prontuarios::consultarHistorico');
    $routes->get('historico/(:num)', 'Prontuarios::listarHistorico/$1');
    $routes->get('historico/(:num)/(:num)', 'Prontuarios::listarHistorico/$1/$2');
    $routes->get('tramitar/(:num)', 'Prontuarios::tramitarProntuario/$1');
    $routes->get('tramitar/(:num)/(:num)', 'Prontuarios::tramitarProntuario/$1/$2');
    $routes->get('tramitar', 'Prontuarios::tramitarProntuario');
    $routes->post('tramitar', 'Prontuarios::tramitar');
    $routes->get('solicitar', 'Prontuarios::solicitarProntuario');
    $routes->post('solicitar', 'Prontuarios::solicitar');
    $routes->get('receber', 'Prontuarios::receberProntuario');
    $routes->get('receber/(:num)', 'Prontuarios::receberProntuario/$1');
    $routes->get('receber/(:num)/(:num)', 'Prontuarios::receberProntuario/$1/$2');
    $routes->post('receber', 'Prontuarios::receber');
    $routes->get('receberemlote', 'Prontuarios::receberEmLote');
    $routes->get('resgatar', 'Prontuarios::resgatarProntuario');
    $routes->post('resgatar', 'Prontuarios::resgatar');
    $routes->get('recuperar', 'Prontuarios::recuperarProntuario');
    $routes->get('enviadosparaosetor', 'Prontuarios::listarProntuariosEnviadosParaSetor');
    $routes->get('exibir', 'ListaEspera::exibirListaEspera');
    $routes->get('solicitacoesexternas', 'Prontuarios::listarSolicitacoesExternas');
    $routes->get('solicitacoes/excluir/(:num)', 'Prontuarios::excluirSolicitacao/$1');
    $routes->get('recuperar/(:num)/(:num)', 'Prontuarios::recuperar/$1/$2');
    $routes->get('recuperar/(:num)/(:num)/(:num)', 'Prontuarios::recuperar/$1/$2/$3');
    $routes->get('consultar', 'ListaEspera::consultarListaEspera');
    $routes->post('listar', 'Prontuarios::exibir');
    $routes->get('editar/(:num)', 'Prontuarios::editar_prontuario/$1');
    $routes->get('criarvolume/(:num)', 'Prontuarios::criar_volume/$1');
    $routes->get('excluirvolume/(:num)', 'Prontuarios::excluir_volume/$1');
    $routes->post('editar/(:num)', 'Prontuarios::editar/$1');
    $routes->get('importarvolssgh/(:num)/(:num)', 'Prontuarios::importar_vol_ssgh/$1/$2');
    $routes->get('importarvolmv/(:num)/(:num)', 'Prontuarios::importar_vol_mv/$1/$2');
});

$routes->group('movimentacoes', function ($routes) {
    $routes->get('', 'Movimentacoes');
    $routes->post('', 'Movimentacoes::create');
    $routes->get('listar', 'Movimentacoes::getMovimentacoes');
    $routes->get('historico/(:num)', 'Movimentacoes::getHistorico/$1');
    $routes->get('(:num)', 'Movimentacoes::show/$1');
    $routes->patch('(:num)', 'Movimentacoes::update/$1');
    $routes->delete('(:num)', 'Movimentacoes::delete/$1');
});

$routes->group('agendas', function ($routes) {
    $routes->get('', 'Agendas');
    /* $routes->get('listar', 'Agendas::listarAgendas'); */
    $routes->get('recuperaragendas', 'Agendas::recuperarAgendas');
    $routes->add('recuperar', 'Agendas::recuperar', ['get', 'post']);
    $routes->post('enviar', 'Agendas::enviarAgendas');
    $routes->get('enviar/(:any)', 'Agendas::enviarAgendas/$1');
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

$routes->group('setores', function ($routes) {
    $routes->get('', 'Setores');
    $routes->post('', 'Setores::create');
    $routes->get('list', 'Setores::getSetores');
    $routes->get('(:num)', 'Setores::show/$1');
    $routes->patch('(:num)', 'Setores::update/$1');
    $routes->delete('(:num)', 'Setores::delete/$1');
    $routes->get('incluir', 'Setores::incluir_setor');
    $routes->get('editar/(:num)', 'Setores::editar_setor/$1');
    $routes->post('incluir', 'Setores::incluir');
    $routes->post('editar/(:num)', 'Setores::editar/$1');
    $routes->get('excluir/(:num)', 'Setores::excluir/$1');
    $routes->get('listar', 'Setores::listar');
    $routes->get('carregarPagina/(:segment)', 'Setores::carregarPagina/$1');
    $routes->get('teste', 'Setores::teste_table');
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