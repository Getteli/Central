<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\License as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Http\Requests\EntidadeRequest;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\PaymentMail;
use App\Mail\Emails;
use App\CodeRandom;
use App\Entidade;
use App\Recebido;
use App\Endereco;
use App\Contato;
use App\Cliente;


class Licenses extends Authenticatable implements MustVerifyEmailContract
{
	use MustVerifyEmail, Notifiable;

	// Definimos a conexão para o banco de license para este model
	protected $connection = 'mysql_two';

	protected $table = "licenses";
	protected $primaryKey = 'idLicense';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'codLicense',
		'codCliente',
		'observacao',
		'special',
		'dias',
		'deletado',
		'ativo',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		//'password', 'Rg',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		//'email_verified_at' => 'datetime',
	];

	protected $guarded = ['idLicense', 'created_at', 'update_at'];

	// METODOS
	
	public function VerifyLicense($codLicense)
	{
		// busca a licença pelo codigo
		$licenseCliente = Licenses::where([['codLicense','=',$codLicense],
		['ativo','=',1]])
		->Where(function ($query) {
			$query->where('deletado','=',0)
			->orWhere('deletado','=',null);
		})
		->first();
		// verifica se existe o registro
		if (!$licenseCliente) {
			return "false";
		}else{
			// pega os dias
			$dias = $licenseCliente->dias;
			if ($dias >= 0) {
				return "true";
			}else{
				// impede de entrar no site e envia um email para este cliente
				$codCliente = $licenseCliente->codCliente;
				$cliente = Cliente::where('codCliente','=',$codCliente)->first();
				$entidade = Entidade::find($cliente->idEntidade);
				//funcao de enviar email
				// falando sobre o erro e mostrando outros dados
				//Mail::to($entidade->email)->send(new Emails("Exibir","ListagemComSegmento",$e->getMessage(),'now'));
				//$entidade->email
				return "false";
			}
		}
	}

	// recebe do pagseguro para atualizar a licença do cliente e informar
	public function PaymentCliente($codLicense, $status)
	{
		try{
			$licenseCliente = Licenses::where('codLicense','=',$codLicense)->first();
			$entidade = Cliente::where('codCliente','=',$licenseCliente->codCliente)->first()->Entidade;
			$cliente = Cliente::where('codCliente','=',$licenseCliente->codCliente)->first();
			$plano = Cliente::where('codCliente','=',$licenseCliente->codCliente)->first()->Plano;

			if($licenseCliente && $entidade && $cliente && $plano){
				// verifica o status do pagamento vindo do pagseguro
				// switch ($status) {
				// 	case 1:
				// 		# code...
				// 		break;
					
				// 	default:
				// 		# code...
				// 		break;
				// }

				// cria o registro informando o recebido
				$recebido = new Recebido();
				$check_recebido = $recebido->CreateRecebido($plano);

				if(!$check_recebido){
					throw new \Exception("Erro ao criar o registro de recebido.");
				}

				// coloca mais 1 mes
				$licenseCliente->dias = $licenseCliente->dias + 31;
				$licenseCliente->update();

				// envia email pro cliente se deu tudo certo
				// envia o obj cliente, entidade, licensa e o status
				Mail::to($entidade->email)->send(new PaymentMail($cliente, $entidade, $licenseCliente, $status));

			}else{
				throw new \Exception("Erro ao acessar a licença e o cliente.");
			}

		}catch(\Exception $e){
			// envia email pro suporte
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Pagar","PaymentCliente",$e->getMessage(),'now'));
		}
	}

	// recebe o cod de licença do cliente pela pagina de payment e retorna os dados do cliente
	public function GetDataCliente($codLicense)
	{
		$dadosCliente = array();
		try{
			$licenseCliente = Licenses::where('codLicense','=',$codLicense)->first();
			$entidade = Cliente::where('codCliente','=',$licenseCliente->codCliente)->first()->Entidade;
			$cliente = Cliente::where('codCliente','=',$licenseCliente->codCliente)->first();

			if($licenseCliente && $entidade && $cliente){
				// pega o primeiro endereco do cliente
				$enderecoCliente = Endereco::where([['idEntidade','=',$entidade->idEntidade],
				['ativo','=',1]])
				->Where(function ($query) {
					$query->where('deletado','=',0)
					->orWhere('deletado','=',null);
				})
				->first();

				// pega o primeiro contato do cliente
				$contatoCliente = Contato::where([['idEntidade','=',$entidade->idEntidade],
				['ativo','=',1]])
				->Where(function ($query) {
					$query->where('deletado','=',0)
					->orWhere('deletado','=',null);
				})
				->first();

				// cria o arrray com o que é necessário
				$dadosCliente = array(
					// key => value
					'nomeCliente' => $entidade->primeiroNome . " " . $entidade->sobrenome,
					'emailCliente' => $entidade->email,
					'dataNascimentoCliente' => $entidade->dataNascimento,
					'enderecoCliente' => $enderecoCliente,
					'dddCliente' => $contatoCliente != null ? $contatoCliente->ddd : null,
					'numeroCliente' => $contatoCliente != null ? $contatoCliente->numero : null,
				);

				return json_encode($dadosCliente);
			}else{
				throw new Exception("Erro ao acessar a licença e o cliente.");
			}
		}catch(\Exception $e){
			// envia email pro suporte
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Exibir","GetDataCliente",$e->getMessage(),'now'));
			// retorna ao cliente
			return 'error';
		}
	}

	public function CreateLicenseCliente(EntidadeRequest $request, $codCliente)
	{
		try{
			$dados = $request->all();

			// cliente registrado com sucesso até aqui, agora crie um registro de licença
			$license = new Licenses();
			$license->codCliente = $codCliente;
			$license->dias = 31; //padrao começa com 31 dias
			$license->ativo = true;
			// a data de licensa é o dia do pagamento. até chegar no dia de pagamento a primeira vez, o contador não transcorre
			$license->dataLicense = $dados['dataPagamentoPlano'];
			$license->codLicense = $this->GetCodLicense($codCliente);
			$license->observacao = $dados['observacaoLicense'];
			$license->special = $dados['especialLicense'];
			$license->save();

			\Session::flash('mensagem',['msg'=>'Novo cliente criado com sucesso! Código do Cliente: '. $license->codLicense .'<br/>Crie o script na pasta do cliente e adicione o código dele.','class'=>'green white-text']);
			return redirect()->route('clientes');

		}catch(\Exception $e){
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Criar","CreateLicenseCliente",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back()->withInput($request->all);
		}
	}

	public function UpdateLicenseCliente(EntidadeRequest $request, $codCliente)
	{
		try{
			$dados = $request->all();

			$license = Licenses::where('codCliente', '=', $codCliente)->first();

			if($license){
				$license->observacao = $dados['observacaoLicense'];
				$license->special = $dados['especialLicense'];
				// se ele atualizar a data de pagamento, atualizar a data de licença
				// planejar isto
				//$license->dataLicense = $dados['dataPagamentoPlano'];
				$license->update();				
			}
			\Session::flash('mensagem',['msg'=>'Cliente atualizado com sucesso!','class'=>'green white-text']);
			return redirect()->back()->withInput($request->all);
		}catch(\Exception $e){
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Atualizar","UpdateLicenseCliente",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back()->withInput($request->all);
		}
	}

	public function EditarLicenseCliente($codCliente)
	{
		try{
			$license = Cliente::where([['codCliente','=',$codCliente],
			['ativo','=',1]])
			->Where(function ($query) {
				$query->where('deletado','=',0)
				->orWhere('deletado','=',null);
			})
			->first();
			if(!$license){
				$license = null;
			}
			
			return $license;
		}catch(\Exception $e){
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Editar","EditarLicenseCliente",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back()->with('isErrorL',1);
		}
	}

	public function DesativarLicenseCliente($codCliente)
	{
		try{
			$license = Licenses::where('codCliente', '=', $codCliente)->where('ativo', '=', 1)->first();
			$license->ativo = false;
			$license->update();

			\Session::flash('mensagem',['msg'=>'Cliente desativado com sucesso.','class'=>'green white-text']);
			return redirect()->back();
		} catch (\Exception $e) {
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Desativar","DesativarLicenseCliente",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back();
		}
	}

	public function AtivarLicenseCliente($codCliente)
	{
		try{
			$license = Licenses::where('codCliente', '=', $codCliente)->where('ativo', '=', 0)->first();
			$license->ativo = true;
			$license->update();

			\Session::flash('mensagem',['msg'=>'Cliente ativado com sucesso.','class'=>'green white-text']);
			return redirect()->back();
		}catch(\Exception $e) {
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Ativar","AtivarLicenseCliente",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back();
		}
	}

	public function DeletarLicenseCliente($codCliente)
	{
		try{
			$license = Licenses::where('codCliente', '=', $codCliente)->first();
			$license->ativo = false;
			$license->desativado = true;
			$license->update();

			\Session::flash('mensagem',['msg'=>'Cliente deletado com sucesso.','class'=>'green white-text']);
			return redirect()->back();
		} catch (\Exception $e) {
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Deletar","DeletarLicenseCliente",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back();
		}
	}

	public function GetCodLicense($codCli){
		$codP = new CodeRandom;
		$cod = $codP->CreateCodLicense($codCli);
		return $cod;
	}
}