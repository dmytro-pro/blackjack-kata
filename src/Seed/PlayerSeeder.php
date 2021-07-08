<?php

namespace App\Seed;

use App\Model\Player;
use WouterJ\EloquentBundle\Seeder;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Player::query()->firstOrCreate([
            'name' => 'Bank',
            'game_id' => 1,
            'is_bank' => true,
        ]);
        Player::query()->firstOrCreate([
            'name' => 'Player #1',
            'game_id' => 1,
            'is_back' => false,
        ]);
        Player::query()->firstOrCreate([
            'name' => 'Player #2',
            'game_id' => 1,
            'is_back' => false,
        ]);
    }
}
