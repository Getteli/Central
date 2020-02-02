<?php

use Illuminate\Database\Seeder;
use App\usuario;

class UsuarioSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Usu = new usuario();

        $Usu->Funcao = "Administrador";
        $Usu->IdEntidade = 1;
        $Usu->save();

        $this->command->info('Seed usuario exemplo -- Central');
    }
}
