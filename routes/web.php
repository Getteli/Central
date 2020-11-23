<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ROTAS PADROES

// rota padrao de login
//Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');

// ROTAS

// Cancela a rota de registro
Auth::routes(['register' => false]);

// auth's
Route::post('/login',['as'=>'login', 'uses'=>'AuthController@login']);

// rota para coisas que sejam de fora do sistema
// license (acessado pela url do cliente para saber se pode acessar)
Route::get('/licenses/blockAll/{codLicense}',['as'=>'license.blockall', 'uses'=>'LicenseController@blockall']);
Route::get('/licenses/getDataCliente/{codLicense}',['as'=>'license.getDataCliente', 'uses'=>'LicenseController@getDataCliente']);
Route::any('/licenses/UpdatePaymenteCliente/{codLicense}/{status}',['as'=>'license.UpdatePaymenteCliente', 'uses'=>'LicenseController@UpdatePaymenteCliente']);

// emails (em formularios de clientes e etc, fazemos o processo de envio direto pelo laravel)
Route::get('/mail/sendMailClient/{request}',['as'=>'mail.sendMailClient', 'uses'=>'MailController@sendMailClient']);

// cron job, agendado
Route::any('/cron/lessDay/',['as'=>'cron.lessDay', 'uses'=>'CronController@CronLessDay']);
Route::any('/cron/verifyPayment/',['as'=>'cron.verifyPayment', 'uses'=>'CronController@CronVerifyPayment']);

// rotas only AUTH TRUE, somente logado
Route::group(['middleware'=>'auth'], function(){
	// rotas auth's, logout
	Route::get('/logout',['as'=>'logout', 'uses'=>'AuthController@logout']);

	// dashboard
	Route::get('/',['as'=>'dashboard', function () {
		return view('dashboard');
	}]);

	// ROTAS

	// cliente
	Route::get('/cliente/adicionar',['as'=>'cliente.adicionar', function () {
		return view('content.cliente.adicionar');
	}]);
	Route::get('/clientes',['as'=>'clientes', 'uses'=>'ClienteController@list']);
	Route::get('/cliente/{idCliente}/{idEntidade}',['as'=>'cliente.editar', 'uses'=>'ClienteController@editar']);
	Route::post('/cliente/salvar',['as'=>'cliente.salvar', 'uses'=>'ClienteController@adicionar']);
	Route::post('/cliente/atualizar/{idEntidade}/{idPlano}/{idCliente}',['as'=>'cliente.atualizar', 'uses'=>'ClienteController@atualizar']);
	Route::post('/cliente/deleteContato',['as'=>'cliente.deleteContato', 'uses'=>'ClienteController@deleteContato']);
	Route::post('/cliente/deleteEndereco',['as'=>'cliente.deleteEndereco', 'uses'=>'ClienteController@deleteEndereco']);
	Route::get('/clientes/deletarEntidade/{idEntidade}',['as'=>'cliente.deleteEntidade', 'uses'=>'ClienteController@deleteEntidade']);
	Route::get('/clientes/desativarEntidade/{idEntidade}',['as'=>'cliente.desativarEntidade', 'uses'=>'ClienteController@desativarEntidade']);
	Route::get('/clientes/ativarEntidade/{idEntidade}',['as'=>'cliente.ativarEntidade', 'uses'=>'ClienteController@ativarEntidade']);
	Route::get('/clientes/filtro/buscar',['as'=>'cliente.filter', 'uses'=>'ClienteController@filter']);
	// -------------------------------------------------------------------------

	// segmento
	Route::get('/segmento/adicionar',['as'=>'segmento.adicionar', function () {
		return view('content.segmento.adicionar');
	}]);
	Route::get('/segmentos',['as'=>'segmentos', 'uses'=>'SegmentoController@list']);
	Route::get('/segmentos/{idSegmento}',['as'=>'segmento.editar', 'uses'=>'SegmentoController@editar']);
	Route::post('/segmento/salvar',['as'=>'segmento.salvar', 'uses'=>'SegmentoController@adicionar']);
	Route::post('/segmentos/atualizar/{idSegmento}',['as'=>'segmento.atualizar', 'uses'=>'SegmentoController@atualizar']);
	Route::get('/segmentos/deletarSegmento/{idSegmento}',['as'=>'segmento.deleteSegmento', 'uses'=>'SegmentoController@deleteSegmento']);
	Route::get('/segmentos/desativarSegmento/{idSegmento}',['as'=>'segmento.desativarSegmento', 'uses'=>'SegmentoController@desativarSegmento']);
	Route::get('/segmentos/ativarSegmento/{idSegmento}',['as'=>'segmento.ativarSegmento', 'uses'=>'SegmentoController@ativarSegmento']);
	Route::get('/segmentos/filtro/buscar',['as'=>'segmento.filter', 'uses'=>'SegmentoController@filter']);
	// -------------------------------------------------------------------------

	// servico
	Route::get('/servico/adicionar',['as'=>'servico.adicionar', function () {
		return view('content.servico.adicionar');
	}]);
	Route::get('/servicos',['as'=>'servicos', 'uses'=>'ServicoController@list']);
	Route::get('/servicos/{idServico}',['as'=>'servico.editar', 'uses'=>'ServicoController@editar']);
	Route::post('/servico/salvar',['as'=>'servico.salvar', 'uses'=>'ServicoController@adicionar']);
	Route::post('/servicos/atualizar/{idServico}',['as'=>'servico.atualizar', 'uses'=>'ServicoController@atualizar']);
	// listagem de serviços sobre um segmento
	Route::post('/servicos/listagemComSegmento',['as'=>'servico.ListagemComSegmento', 'uses'=>'ServicoController@ListagemComSegmento']);
	Route::get('/servicos/deletarServico/{idServico}',['as'=>'servico.deleteServico', 'uses'=>'ServicoController@deleteServico']);
	Route::get('/servicos/desativarServico/{idServico}',['as'=>'servico.desativarServico', 'uses'=>'ServicoController@desativarServico']);
	Route::get('/servicos/ativarServico/{idServico}',['as'=>'servico.ativarServico', 'uses'=>'ServicoController@ativarServico']);
	Route::get('/servicos/filtro/buscar',['as'=>'servico.filter', 'uses'=>'ServicoController@filter']);
	// -------------------------------------------------------------------------

	// plano
	Route::get('/planos',['as'=>'planos', 'uses'=>'PlanoController@list']);
	Route::get('/planos/{idPlano}',['as'=>'plano.editar', 'uses'=>'PlanoController@editar']);
	Route::get('/planos/filtro/buscar',['as'=>'plano.filter', 'uses'=>'PlanoController@filter']);
});
