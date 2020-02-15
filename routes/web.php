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

#region ROTAS PADROES
// rota padrao de login
//Auth::routes();

// Cancela a rota de registro
Auth::routes(['register' => false]);

// rota padrao para ir ao dashboard
//Route::get('/home', 'HomeController@index')->name('home');
#endregion

// rotas auth's
Route::post('/login',['as'=>'login', 'uses'=>'AuthController@login']);

// ROTAS
// cliente
Route::get('/cliente/adicionar',['as'=>'cliente.adicionar', function () {
    return view('content.cliente.adicionar');
}]);

Route::get('/clientes',['as'=>'clientes', 'uses'=>'ClienteController@list']);

Route::get('/clientes/{idCliente}/{idEntidade}',['as'=>'cliente.editar', 'uses'=>'ClienteController@editar']);

// segmento
Route::get('/segmento/adicionar',['as'=>'segmento.adicionar', function () {
    return view('content.segmento.adicionar');
}]);

Route::get('/segmentos',['as'=>'segmentos', 'uses'=>'SegmentoController@list']);

Route::get('/segmentos/{idSegmento}',['as'=>'segmento.editar', 'uses'=>'SegmentoController@editar']);

// servicos
Route::get('/servico/adicionar',['as'=>'servico.adicionar', function () {
    return view('content.servico.adicionar');
}]);

Route::get('/servicos',['as'=>'servicos', 'uses'=>'ServicoController@list']);

Route::get('/servicos/{idServico}',['as'=>'servico.editar', 'uses'=>'ServicoController@editar']);


// rotas only AUTH TRUE
Route::group(['middleware'=>'auth'], function(){
    // rotas auth's
    Route::get('/logout',['as'=>'logout', 'uses'=>'AuthController@logout']);

    // dashboard
    Route::get('/',['as'=>'dashboard', function () {
        return view('dashboard');
    }]);

    // rotas adicionar e atualizar
    // cliente
    Route::post('/cliente/salvar',['as'=>'cliente.salvar', 'uses'=>'ClienteController@adicionar']);
    Route::post('/clientes/atualizar',['as'=>'cliente.atualizar', 'uses'=>'ClienteController@atualizar']);

    // segmento
    Route::post('/segmento/salvar',['as'=>'segmento.salvar', 'uses'=>'SegmentoController@adicionar']);
    Route::post('/segmentos/atualizar',['as'=>'segmento.atualizar', 'uses'=>'SegmentoController@atualizar']);

    // servico
    Route::post('/servico/salvar',['as'=>'servico.salvar', 'uses'=>'ServicoController@adicionar']);
    Route::post('/servicos/atualizar',['as'=>'servico.atualizar', 'uses'=>'ServicoController@atualizar']);

});