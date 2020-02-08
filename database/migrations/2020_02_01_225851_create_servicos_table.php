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
            $table->Increments('idServico');
            $table->string("servico",30);
            $table->string("descricao",90);
            $table->decimal("preco",10,2);

            $table->integer('idSegmento')->unsigned()->nullable();
            $table->foreign('idSegmento')->references('IdSegmento')->on('segmentos')->onDelete('cascade');

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
        Schema::dropIfExists('servicos');
    }
}
