<?php

use Illuminate\Database\Seeder;
use App\Entidade;
use App\User;

class EntidadeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->command->info('Seed entidade pertencente ao usuario -- Central');
        if(!Entidade::where('email','=','agenc921_admin@publikando.com')->count()){
            $Entidade = new Entidade();

            $Entidade->primeiroNome = "Admin";
            $Entidade->email = "agenc921_admin@publikando.com";
            $Entidade->apelido = "Admin";
            $Entidade->ativo = true;
            $Entidade->save();
        }
        
        $this->command->info('Seed entidade pertencente ao usuario rodado com sucesso -- Central');

        //
        $this->command->info('Seed usuario-entidade -- Central');

        if(!User::where('email','=','agenc921_admin@publikando.com')->count()){
            $User = new User();

            $User->name = "Admin";
            $User->email = "agenc921_admin@publikando.com";
            $User->funcao = "Administrador";
            $User->ativo = true;
            $User->password = Hash::make("publik@ndo.2020");
            $User->save();

            // add a chave estrangeira a entidade onde esta o resto das informacoes dele
            $lstIdEntidade = $Entidade->idEntidade; // busca o id do objecto criado (obs: msm o meu id se chamando idEntidade, o metodo para chamar esse atributo sempre sera id)

            // se nao for um numero maior que zero, ou seja nao for um numero, da erro, se nao continua
            if(!($lstIdEntidade > 0)){
                $this->command->info('ERRO AO BUSCAR O ID DO USUARIO ADD');
            }else{
                // busca o usuario add agora, pelo seu id do obj
                $UpUser = User::find($User->id);
                // coloca o id da entidade na fk
                $UpUser->idEntidade = $lstIdEntidade;
                // atualiza
                $UpUser->update();
            }
        }
        
        $this->command->info('Seed usuario-entidade da rodado com sucesso -- Central');

    }
}