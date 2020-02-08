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
        $this->command->info('Seeds RODADNDO...');

        $this->call(EntidadeSeed::class);
        $this->call(PapelSeed::class);
        $this->call(PermissaoSeed::class);

        $this->command->info('Seeds rodado com SUCESSO !');
    }
}