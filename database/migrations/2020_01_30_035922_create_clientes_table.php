<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('IdCliente');
            $table->dateTime("DataPagamento")->nullable();
            $table->char("CodCliente",5);
            $table->char("Cnpj",19)->nullable();
            $table->mediumText("Link")->nullable();
            $table->string("RazaoSocial",45)->nullable();

            $table->integer('IdEntidade')->unsigned()->nullable();
            $table->foreign('IdEntidade')->references('IdEntidade')->on('entidades');

            $table->integer('IdPlano')->unsigned()->nullable();
            $table->foreign('IdPlano')->references('IdPlano')->on('planos');

            $table->timestamps(); // datacadastro e modificado
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
