<?php

namespace App\Seed;

use App\Model\Game;
use WouterJ\EloquentBundle\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Game::query()->firstOrCreate([
            'id' => 1,
            'bank_player_id' => 1,
        ]);
    }
}
