<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePapeisPermissoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papeisPermissoes', function (Blueprint $table) {
            $table->integer('IdPapel')->unsigned()->nullable();
            $table->foreign('IdPapel')->references('IdPapel')->on('papers');

            $table->integer('IdPermissao')->unsigned()->nullable();
            $table->foreign('IdPermissao')->references('IdPermissao')->on('permissoes');

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
        Schema::dropIfExists('papeisPermissoes');
    }
}
