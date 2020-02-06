<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string("funcao",30)->nullable();

            $table->string('name');
            $table->string("email",45)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->integer('idEntidade')->unsigned()->nullable();
            $table->foreign('idEntidade')->references('idEntidade')->on('entidades');

            $table->integer('idPapel')->unsigned()->nullable();
            $table->foreign('idPapel')->references('idPapel')->on('papers');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
