<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('IdUsuario');
            $table->string("Funcao",30)->nullable();

            $table->integer('IdEntidade')->unsigned()->nullable();
            $table->foreign('IdEntidade')->references('IdEntidade')->on('entidades');

            $table->integer('IdPapel')->unsigned()->nullable();
            $table->foreign('IdPapel')->references('IdPapel')->on('papers');

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
        Schema::dropIfExists('usuarios');
    }
}
