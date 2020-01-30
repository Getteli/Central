<?php

use Illuminate\Database\Seeder;

use App\Entidade;

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
        $Entidade = new Entidade();

        $Entidade->PrimeiroNome = "Douglas";
        $Entidade->SobreNome = "Araujo";
        $Entidade->PrimeiroNome = "Douglas";
        $Entidade->Email = "Douglas_Araujo018@outlook.com";
        $Entidade->Ativo = 1;
        $Entidade->Sexo = "M";
        $Entidade->Apelido = "Getteli";
        $Entidade->Cpf = "110.136.717-24";
        $Entidade->Password = Hash::make("Douglas05");
        $Entidade->save();

        $this->command->info('Seed entidade exemplo -- Central');
    }
}
