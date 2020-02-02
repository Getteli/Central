<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_two')->create('licenses', function (Blueprint $table) {
            $table->Increments('IdLicense');
            $table->string("CodLicense",100);
            $table->dateTime("DataLicense");
            $table->char("CodCliente",5);
            $table->string("Observacao",100)->nullable();
            $table->string("Special",10)->nullable();
            $table->integer("Dias")->nullable();
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
        Schema::connection('mysql_two')->dropIfExists('licenses');
    }
}
