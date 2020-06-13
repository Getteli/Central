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
            $table->Increments('idEndereco');
            $table->string("numero",10);
            $table->string("descricao",45)->nullable();
            $table->char("estado",2);
            $table->string("cidade",45);
            $table->string("bairro",45);
            $table->string("logradouro",90);
            $table->string("complemento",45)->nullable();
            $table->char("cep",10);

            $table->integer('idEntidade')->unsigned()->nullable();
            $table->foreign('idEntidade')->references('idEntidade')->on('entidades')->onDelete('cascade')->onUpdate('no action');

            $table->boolean("deletado")->nullable();
            $table->boolean("ativo");
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
