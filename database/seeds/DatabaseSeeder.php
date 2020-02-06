<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(EntidadeSeed::class);
        $this->call(UserSeed::class);
        $this->call(PapelSeed::class);
        $this->call(PermissaoSeed::class);
    }
}
