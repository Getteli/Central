<?php

use Illuminate\Database\Seeder;
use App\Permissao;

class PermissaoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // LISTAR

        $Permissao = Permissao::create([
            'Descricao'=> 'Listar_usuario',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao2 = Permissao::create([
            'Descricao'=> 'Listar_cliente',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao3 = Permissao::create([
            'Descricao'=> 'Listar_tarefas',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao4 = Permissao::create([
            'Descricao'=> 'Listar_eventos',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao5 = Permissao::create([
            'Descricao'=> 'Listar_papeis',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao6 = Permissao::create([
            'Descricao'=> 'Listar_permissoes',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao7 = Permissao::create([
            'Descricao'=> 'Listar_segmentos',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao8 = Permissao::create([
            'Descricao'=> 'Listar_servicos',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao9 = Permissao::create([
            'Descricao'=> 'Listar_contas',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        // CRIAR

        $Permissao10 = Permissao::create([
            'Descricao'=> 'criar_usuario',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao11 = Permissao::create([
            'Descricao'=> 'criar_cliente',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao12 = Permissao::create([
            'Descricao'=> 'criar_evento',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao13 = Permissao::create([
            'Descricao'=> 'criar_segmento',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao14 = Permissao::create([
            'Descricao'=> 'criar_servicos',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao15 = Permissao::create([
            'Descricao'=> 'criar_tarefa',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao16 = Permissao::create([
            'Descricao'=> 'criar_papel',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao17 = Permissao::create([
            'Descricao'=> 'criar_permissao',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao18 = Permissao::create([
            'Descricao'=> 'criar_contas',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        // EDITAR

        $Permissao19 = Permissao::create([
            'Descricao'=> 'editar_usuario',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao20 = Permissao::create([
            'Descricao'=> 'editar_cliente',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao21 = Permissao::create([
            'Descricao'=> 'editar_evento',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao22 = Permissao::create([
            'Descricao'=> 'editar_segmento',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao23 = Permissao::create([
            'Descricao'=> 'editar_servicos',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao24 = Permissao::create([
            'Descricao'=> 'editar_tarefa',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao25 = Permissao::create([
            'Descricao'=> 'editar_papel',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao26 = Permissao::create([
            'Descricao'=> 'editar_permissao',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao27 = Permissao::create([
            'Descricao'=> 'editar_contas',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        // DELETAR

        $Permissao28 = Permissao::create([
            'Descricao'=> 'deletar_usuario',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao29 = Permissao::create([
            'Descricao'=> 'deletar_cliente',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao30 = Permissao::create([
            'Descricao'=> 'deletar_evento',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao31 = Permissao::create([
            'Descricao'=> 'deletar_segmento',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao32 = Permissao::create([
            'Descricao'=> '_servicdeletaros',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao33 = Permissao::create([
            'Descricao'=> 'deletar_tarefa',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao34 = Permissao::create([
            'Descricao'=> 'deletar_papel',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao35 = Permissao::create([
            'Descricao'=> 'deletar_permissao',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

        $Permissao36 = Permissao::create([
            'Descricao'=> 'deletar_contas',
            'CodPermissao'=> $this->GetCod(),
            'Ativo'=> true
        ]);

    }

    public function GetCod()
    {
        $codP = new Permissao;
        $cod = $codP->CreateCod();
        return $cod;
    }

}
