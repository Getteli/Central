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
        $this->call(EntidadeSeed::class);
        $this->call(UsuarioSeed::class);
        $this->call(ClienteSeed::class);
        $this->call(PapelSeed::class);
    }
}