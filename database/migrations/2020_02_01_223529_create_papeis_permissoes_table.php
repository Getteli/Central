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
            $table->integer('idPapel')->unsigned()->nullable();
            $table->foreign('idPapel')->references('idPapel')->on('papers');

            $table->integer('idPermissao')->unsigned()->nullable();
            $table->foreign('idPermissao')->references('idPermissao')->on('permissoes');

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
