<?php

use Illuminate\Database\Seeder;
use App\Regras\Papel;
use App\CodeRandom;

class PapelSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->command->info('Seed papel -- Central');

        if(!Papel::all()->count()){

            $Papel = Papel::create([
                'descricao'=> 'Papel de administrador',
                'codPapel'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Papel2 = Papel::create([
                'descricao'=> 'Papel de gerente',
                'codPapel'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Papel3 = Papel::create([
                'descricao'=> 'Papel de usuário',
                'codPapel'=> $this->GetCod(),
                'ativo'=> true
            ]);
        }

        $this->command->info('Seed papel rodado com sucesso -- Central');
    }

    public function GetCod(){
        $codP = new CodeRandom;
        $cod = $codP->CreateCod(4);
        return $cod;
    }
}
