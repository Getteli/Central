<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicos', function (Blueprint $table) {
            $table->Increments('IdServico');
            $table->string("Servico",30);
            $table->string("Descricao",90);
            $table->decimal("Preco",10,2);

            $table->integer('IdSegmento')->unsigned()->nullable();
            $table->foreign('IdSegmento')->references('IdSegmento')->on('segmentos');

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
        Schema::dropIfExists('servicos');
    }
}
