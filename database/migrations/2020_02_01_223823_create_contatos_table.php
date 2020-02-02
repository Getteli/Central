<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contatos', function (Blueprint $table) {
            $table->Increments('IdContato');
            $table->boolean("Deletado")->nullable();
            $table->boolean("Ativo");
            $table->string("Identificacao",30)->nullable();
            $table->string("Numero",12)->nullable();
            $table->string("Email",45)->nullable();
            $table->char("Ddd",2)->nullable();

            $table->integer('IdCliente')->unsigned()->nullable();
            $table->foreign('IdCliente')->references('IdCliente')->on('clientes');

            $table->integer('IdUsuario')->unsigned()->nullable();
            $table->foreign('IdUsuario')->references('IdUsuario')->on('usuarios');

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
        Schema::dropIfExists('contatos');
    }
}
