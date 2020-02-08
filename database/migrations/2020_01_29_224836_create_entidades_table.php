<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entidades', function (Blueprint $table) {
            $table->increments('idEntidade');
            $table->dateTime("dataExpedicao")->nullable();
            $table->string("naturalidade",25)->nullable();
            $table->dateTime("dataNascimento")->nullable();
            $table->string("drgaoEmissor",15)->nullable();
            $table->char("rg",13)->nullable();
            $table->string("nacionalidade",25)->nullable();
            $table->char("cpf",15)->nullable();
            $table->boolean("deletado")->nullable();
            $table->boolean("ativo");
            $table->char("sexo",1)->nullable();
            $table->string("sobrenome",45)->nullable();
            $table->string("primeiroNome",45);
            $table->string("email",45)->unique();
            $table->string("apelido",45);
            $table->string("senha",70)->nullable();
            $table->timestamps(); // cada de cadastro e modificado
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entidades');
    }
}
