<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AuthController extends Controller
{

	public function login(Request $request)
	{
		$dados = $request->all();
		
		if(Auth::attempt(['email'=>$dados['email'],'password'=>$dados['password']])){
			
			\Session::flash('mensagem',[
				'title'=> 'Bem Vindo',
				'msg'=> 'Login realizado com sucesso !',
				'class'=> 'green white-text modal-show',
				'class-mc'=> 'green',
				'class-so'=> 'sidenav-overlay-show'
				]);

			return redirect()->route('dashboard');
		}

		\Session::flash('mensagem',[
			'title'=> 'Login',
			'msg'=> 'Erro! Confira seus dados.',
			'class'=> 'red white-text modal-show',
			'class-mc'=> 'red',
			'class-so'=> 'sidenav-overlay-show'
			]);
		return redirect()->back()->withInput($request->all);

	}
	
	public function logout()
	{
		Auth::logout();
		return redirect()->route('dashboard');
	}
}