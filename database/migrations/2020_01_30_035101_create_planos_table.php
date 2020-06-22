<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planos', function (Blueprint $table) {
            $table->Increments('idPlano');
            $table->boolean("deletado")->nullable();
            $table->boolean("ativo");
            $table->decimal("preco",10,2)->nullable();
            $table->text("descricao")->nullable();
            $table->string("formaPagamento",45)->nullable();
            $table->tinyInteger("dataPagamento")->nullable();
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
        Schema::dropIfExists('planos');
    }
}
