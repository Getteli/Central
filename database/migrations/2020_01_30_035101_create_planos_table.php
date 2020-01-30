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
            $table->Increments('IdPlano');
            $table->boolean("Deletado")->nullable();
            $table->boolean("Ativo");
            $table->decimal("Preco",10,2)->nullable();
            $table->text("Descricao")->nullable();
            $table->string("FormaPagamento",45)->nullable();
            $table->dateTime("DataPagamento")->nullable();
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
