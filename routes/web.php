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

// login
// Route::get('/login',['as'=>'login.page', function () {
//     return view('auth.login');
// }]);


// rotas only AUTH TRUE
Route::group(['middleware'=>'auth'], function(){
    // rotas auth's
    Route::get('/logout',['as'=>'logout', 'uses'=>'AuthController@logout']);

    // dashboard
    Route::get('/',['as'=>'dashboard', function () {
        return view('dashboard');
    }]);
});