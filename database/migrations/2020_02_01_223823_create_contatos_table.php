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
            $table->Increments('idContato');
            $table->boolean("deletado")->nullable();
            $table->boolean("ativo");
            $table->string("identificacao",30)->nullable();
            $table->string("numero",12)->nullable();
            $table->string("email",45)->nullable();
            $table->char("ddd",2)->nullable();

            $table->integer('idEntidade')->unsigned()->nullable();
            $table->foreign('idEntidade')->references('idEntidade')->on('entidades')->onDelete('cascade')->onUpdate('no action');

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
