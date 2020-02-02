<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecebidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recebidos', function (Blueprint $table) {
            $table->Increments('IdRecebido');
            $table->decimal("Valor",10,2);
            $table->dateTime("DataEntrada");
            $table->string("Descricao",100);

            $table->integer('IdPlano')->unsigned()->nullable();
            $table->foreign('IdPlano')->references('IdPlano')->on('planos');

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
        Schema::dropIfExists('recebidos');
    }
}
