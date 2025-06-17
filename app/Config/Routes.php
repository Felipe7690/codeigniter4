<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');

$routes->get('/cidades', 'Cidades::index');
$routes->get('/cidades/index', 'Cidades::index');
$routes->get('/cidades/new', 'Cidades::new');
$routes->post('/cidades/create', 'Cidades::create');
$routes->get('/cidades/edit/(:any)', 'Cidades::edit/$1');
$routes->post('/cidades/update', 'Cidades::update');
$routes->post('/cidades/search', 'Cidades::search');
$routes->get('/cidades/delete/(:any)', 'Cidades::delete/$1');

$routes->get('/categorias', 'Categorias::index');
$routes->get('/categorias/index', 'Categorias::index');
$routes->get('/categorias/new', 'Categorias::new');
$routes->post('/categorias/create', 'Categorias::create');
$routes->get('/categorias/edit/(:any)', 'Categorias::edit/$1');
$routes->post('/categorias/update', 'Categorias::update');
$routes->post('/categorias/search', 'Categorias::search');
$routes->get('/categorias/delete/(:any)', 'Categorias::delete/$1');

$routes->get('/produtos', 'Produtos::index');
$routes->get('/produtos/index', 'Produtos::index');
$routes->get('/produtos/new', 'Produtos::new');
$routes->post('/produtos/create', 'Produtos::create');
$routes->get('/produtos/edit/(:any)', 'Produtos::edit/$1');
$routes->post('/produtos/update', 'Produtos::update');
$routes->post('/produtos/search', 'Produtos::search');
$routes->get('/produtos/delete/(:any)', 'Produtos::delete/$1');

$routes->get('/usuarios', 'Usuarios::index');
$routes->get('/usuarios/index', 'Usuarios::index');
$routes->get('/usuarios/new', 'Usuarios::new');
$routes->post('/usuarios/create', 'Usuarios::create');
$routes->get('/usuarios/edit/(:any)', 'Usuarios::edit/$1');
$routes->get('/usuarios/delete/(:any)', 'Usuarios::delete/$1');
$routes->post('/usuarios/update', 'Usuarios::update');
$routes->post('/usuarios/search', 'Usuarios::search');

$routes->get('/usuarios/edit_senha', 'Usuarios::edit_senha');
$routes->post('/usuarios/salvar_senha', 'Usuarios::salvar_senha');

$routes->get('/usuarios/edit_nivel', 'Usuarios::edit_nivel');
$routes->post('/usuarios/salvar_nivel', 'Usuarios::salvar_nivel');

$routes->get('/login', 'Login::index');
$routes->get('/login/index', 'Login::index');
$routes->post('/login/logar', 'Login::logar');
$routes->get('/login/logout', 'Login::logout');


$routes->get('/admin', 'Admin::index');
$routes->get('/admin/index', 'Admin::index');

$routes->get('/user', 'User::index');
$routes->get('/user/index', 'User::index');

$routes->get('/imgprodutos', 'Imgprodutos::index');
$routes->get('/imgprodutos/index', 'Imgprodutos::index');
$routes->get('/imgprodutos/new', 'Imgprodutos::new');
$routes->post('/imgprodutos/create', 'Imgprodutos::create');
$routes->get('/imgprodutos/edit/(:any)', 'Imgprodutos::edit/$1');
$routes->post('/imgprodutos/update', 'Imgprodutos::update');
$routes->post('/imgprodutos/search', 'Imgprodutos::search');
$routes->get('/imgprodutos/delete/(:any)', 'Imgprodutos::delete/$1');

$routes->get('/relatorios', 'Relatorios::index');
$routes->get('/relatorios/index', 'Relatorios::index');

$routes->get('vendas', 'Venda::index');
$routes->get('vendas/(:num)', 'Venda::show/$1');
$routes->post('vendas', 'Venda::create');
$routes->put('vendas/(:num)', 'Venda::update/$1');
$routes->delete('vendas/(:num)', 'Venda::delete/$1');
$routes->get('venda/edit/(:num)', 'Venda::edit/$1');

$routes->get('clientes', 'ClientesController::index');
$routes->get('clientes/create', 'ClientesController::create');
$routes->post('clientes/store', 'ClientesController::store');
$routes->get('clientes/edit/(:num)', 'ClientesController::edit/$1');
$routes->post('clientes/update/(:num)', 'ClientesController::update/$1');
$routes->post('clientes/delete/(:num)', 'ClientesController::delete/$1');
$routes->post('clientes/search', 'ClientesController::search');
$routes->post('clientes/search', 'ClientesController::search');          // pesquisa por nome
$routes->post('clientes/searchEndereco', 'ClientesController::searchEndereco'); // pesquisa por endereço


$routes->get('clientes/editarEndereco/(:num)', 'ClientesController::editarEndereco/$1');
$routes->post('clientes/salvarEndereco/(:num)', 'ClientesController::salvarEndereco/$1');
$routes->get('enderecos', 'ClientesController::enderecos');

$routes->get('estoques', 'EstoquesController::index');
$routes->get('estoques/create', 'EstoquesController::create');
$routes->post('estoques/store', 'EstoquesController::store');
$routes->get('estoques/edit/(:num)', 'EstoquesController::edit/$1');
$routes->post('estoques/update/(:num)', 'EstoquesController::update/$1');
$routes->get('estoques/delete/(:num)', 'EstoquesController::delete/$1');
$routes->post('estoques/delete/(:num)', 'EstoquesController::delete/$1');
$routes->post('estoques/search', 'EstoquesController::search');

// Rotas para Pedidos
$routes->get('pedidos', 'Pedidos::index');
$routes->get('pedidos/create', 'Pedidos::create');
$routes->post('pedidos/store', 'Pedidos::store');












