<?php

namespace App\Seed;

use App\Model\Card;
use WouterJ\EloquentBundle\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $suits = ['spade', 'heart', 'diamond', 'club'];
        $names = [
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
            '10',
            'jack',
            'queen',
            'king',
        ];

        foreach ($suits as $suit) {
            foreach ($names as $name) {
                Card::query()->firstOrCreate([
                    'suit' => $suit,
                    'name' => $name,
                ]);
            }
        }
    }
}
