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
            $table->increments('idCliente');
            $table->dateTime("dataPagamento")->nullable();
            $table->char("codCliente",5);
            $table->char("cnpj",19)->nullable();
            $table->mediumText("link")->nullable();
            $table->string("razaoSocial",45)->nullable();

            $table->integer('idEntidade')->unsigned()->nullable();
            $table->foreign('idEntidade')->references('idEntidade')->on('entidades');

            $table->integer('idPlano')->unsigned()->nullable();
            $table->foreign('idPlano')->references('idPlano')->on('planos');

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