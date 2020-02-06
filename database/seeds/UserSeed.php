<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $User = new User();

        $User->name = "Admin";
        $User->email = "agenc921_admin@publikando.com";
        $User->funcao = "Administrador";
        $User->idEntidade = 1;
        $User->password = Hash::make("publik@ndo.2020");
        $User->save();

        $this->command->info('Seed usuario da central exemplo -- Central');
    }
}
