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

        $Entidade->PrimeiroNome = "Admin";
        $Entidade->Email = "agenc921_admin@publikando.com";
        $Entidade->Apelido = "Admin";
        $Entidade->Ativo = true;
        $Entidade->Password = Hash::make("publik@ndo.2020");
        $Entidade->save();

        $this->command->info('Seed entidade exemplo -- Central');
    }
}
