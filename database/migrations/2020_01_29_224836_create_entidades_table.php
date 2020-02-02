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
            $table->increments('IdEntidade');
            $table->dateTime("DataExpedicao")->nullable();
            $table->string("Naturalidade",25)->nullable();
            $table->dateTime("DataNascimento")->nullable();
            $table->string("OrgaoEmissor",15)->nullable();
            $table->char("Rg",13)->nullable();
            $table->string("Nacionalidade",25)->nullable();
            $table->char("Cpf",15)->nullable();
            $table->boolean("Deletado")->nullable();
            $table->boolean("Ativo");
            $table->char("Sexo",1)->nullable();
            $table->string("Sobrenome",45)->nullable();
            $table->string("PrimeiroNome",45);
            $table->string("Email",45)->unique();
            $table->string("Apelido",45);
            $table->string("Password",70);
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
