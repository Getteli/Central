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
            $table->Increments('idLicense');
            $table->string("codLicense",100)->unique();
            $table->tinyInteger("dataLicense");
            $table->char("codCliente",5);
            $table->string("observacao",100)->nullable();
            $table->string("special",10)->nullable();
            $table->integer("dias")->nullable();
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
        Schema::connection('mysql_two')->dropIfExists('licenses');
    }
}
