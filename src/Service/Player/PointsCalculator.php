<?php


namespace App\Service\Player;

use App\Model\PlayerCard;
use Illuminate\Support\Collection;

class PointsCalculator
{
    const CARD_VALUES = [
        '1' => 11,
        '2' => 2,
        '3' => 3,
        '4' => 4,
        '5' => 5,
        '6' => 6,
        '7' => 7,
        '8' => 8,
        '9' => 9,
        '10' => 10,
        'jack' => 10,
        'queen' => 10,
        'king' => 10,
    ];

    const MAX_VALID_SUM = 21;

    const ACE_VALUE_DEFAULT = 11;
    const ACE_VALUE_IF_OVERFLOW = 1;

    // PlayerCardsCollection
    public function calculatePoints(Collection $cards): int
    {
        $cardValues = $cards->map(function (PlayerCard $v) {
            if ($v->is_hidden) {
                return 0;
            }

            return static::CARD_VALUES[$v->card->name];
        });

        $sum = $cardValues->sum();
        if ($sum > static::MAX_VALID_SUM) {
            $cardValues = $cards->map(function (int $v) {
                if ($v === static::ACE_VALUE_DEFAULT) {
                    return static::ACE_VALUE_IF_OVERFLOW;
                }

                return $v;
            });

            $sum = $cardValues->sum();
        }

        return $sum;
    }
}