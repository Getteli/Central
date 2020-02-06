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
            $table->Increments('idRecebido');
            $table->decimal("valor",10,2);
            $table->dateTime("dataEntrada");
            $table->string("descricao",100);

            $table->integer('idPlano')->unsigned()->nullable();
            $table->foreign('idPlano')->references('idPlano')->on('planos');

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
        Schema::dropIfExists('recebidos');
    }
}
