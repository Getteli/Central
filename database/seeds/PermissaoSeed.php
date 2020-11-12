<?php

use Illuminate\Database\Seeder;
use App\Regras\Permissao;
use App\CodeRandom;

class PermissaoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Seed permissoes -- Central');

        // LISTAR
        if(!Permissao::all()->count()){

            $Permissao = Permissao::create([
                'descricao'=> 'Listar_usuario',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao2 = Permissao::create([
                'descricao'=> 'Listar_cliente',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao3 = Permissao::create([
                'descricao'=> 'Listar_tarefas',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao4 = Permissao::create([
                'descricao'=> 'Listar_eventos',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao5 = Permissao::create([
                'descricao'=> 'Listar_papeis',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao6 = Permissao::create([
                'descricao'=> 'Listar_permissoes',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao7 = Permissao::create([
                'descricao'=> 'Listar_segmentos',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao8 = Permissao::create([
                'descricao'=> 'Listar_servicos',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao9 = Permissao::create([
                'descricao'=> 'Listar_contas',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            // CRIAR

            $Permissao10 = Permissao::create([
                'descricao'=> 'criar_usuario',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao11 = Permissao::create([
                'descricao'=> 'criar_cliente',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao12 = Permissao::create([
                'descricao'=> 'criar_evento',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao13 = Permissao::create([
                'descricao'=> 'criar_segmento',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao14 = Permissao::create([
                'descricao'=> 'criar_servicos',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao15 = Permissao::create([
                'descricao'=> 'criar_tarefa',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao16 = Permissao::create([
                'descricao'=> 'criar_papel',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao17 = Permissao::create([
                'descricao'=> 'criar_permissao',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao18 = Permissao::create([
                'descricao'=> 'criar_contas',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            // EDITAR

            $Permissao19 = Permissao::create([
                'descricao'=> 'editar_usuario',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao20 = Permissao::create([
                'descricao'=> 'editar_cliente',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao21 = Permissao::create([
                'descricao'=> 'editar_evento',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao22 = Permissao::create([
                'descricao'=> 'editar_segmento',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao23 = Permissao::create([
                'descricao'=> 'editar_servicos',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao24 = Permissao::create([
                'descricao'=> 'editar_tarefa',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao25 = Permissao::create([
                'descricao'=> 'editar_papel',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao26 = Permissao::create([
                'descricao'=> 'editar_permissao',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao27 = Permissao::create([
                'descricao'=> 'editar_contas',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            // DELETAR

            $Permissao28 = Permissao::create([
                'descricao'=> 'deletar_usuario',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao29 = Permissao::create([
                'descricao'=> 'deletar_cliente',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao30 = Permissao::create([
                'descricao'=> 'deletar_evento',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao31 = Permissao::create([
                'descricao'=> 'deletar_segmento',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao32 = Permissao::create([
                'descricao'=> '_servicdeletaros',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao33 = Permissao::create([
                'descricao'=> 'deletar_tarefa',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao34 = Permissao::create([
                'descricao'=> 'deletar_papel',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao35 = Permissao::create([
                'descricao'=> 'deletar_permissao',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

            $Permissao36 = Permissao::create([
                'descricao'=> 'deletar_contas',
                'codPermissao'=> $this->GetCod(),
                'ativo'=> true
            ]);

        }

        $this->command->info('Seed permissoes rodado com sucesso -- Central');

    }

    public function GetCod()
    {
        $codP = new CodeRandom;
        $cod = $codP->CreateCod(4);
        return $cod;
    }

}
