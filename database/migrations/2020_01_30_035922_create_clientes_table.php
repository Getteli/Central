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
            $table->tinyInteger("dataPagamento")->nullable();
            $table->char("codCliente",5)->unique();
            $table->char("cnpj",19)->nullable();
            $table->mediumText("link")->nullable();
            $table->string("razaoSocial",45)->nullable();

            $table->integer('idEntidade')->unsigned()->unique()->nullable();
            $table->foreign('idEntidade')->references('idEntidade')->on('entidades')->onDelete('cascade')->onUpdate('no action');

            $table->integer('idPlano')->unsigned()->nullable();
            $table->foreign('idPlano')->references('idPlano')->on('planos')->onDelete('cascade');
            $table->boolean("deletado")->nullable();
            $table->boolean("ativo");
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
