<?php

use Illuminate\Database\Seeder;
use App\Papel;

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

        $Papel = Papel::create([
            'Descricao'=> 'Papel de administrador',
            'CodPapel'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Papel2 = Papel::create([
            'Descricao'=> 'Papel de gerente',
            'CodPapel'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Papel3 = Papel::create([
            'Descricao'=> 'Papel de usuário',
            'CodPapel'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $this->command->info('Seed papel exemplo -- Central');
    }

    public function GetCod(){
        $codP = new Papel;
        $cod = $codP->CreateCod();
        return $cod;
    }
}
