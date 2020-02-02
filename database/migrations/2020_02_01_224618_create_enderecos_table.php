<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnderecosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->Increments('IdEndereco');
            $table->string("Numero",10);
            $table->string("Descricao",45)->nullable();
            $table->char("Estado",2);
            $table->string("Cidade",45);
            $table->string("Bairro",45);
            $table->string("Logradouro",90);
            $table->string("Complemento",45)->nullable();
            $table->char("Cep",10);

            $table->integer('IdCliente')->unsigned()->nullable();
            $table->foreign('IdCliente')->references('IdCliente')->on('clientes');

            $table->integer('IdUsuario')->unsigned()->nullable();
            $table->foreign('IdUsuario')->references('IdUsuario')->on('usuarios');

            $table->boolean("Deletado")->nullable();
            $table->boolean("Ativo");
            $table->timestamps(); // data cadastro e modificado
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enderecos');
    }
}
