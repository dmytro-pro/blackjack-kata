<?php


namespace App\Service;


use App\Model\Game;
use App\Model\Player;
use App\Model\PlayerCard;

class Distributor
{
    public function hit(Game $game, Player $player, $isHidden = false): ?PlayerCard
    {
        /** @var PlayerCard[] $playerCards */
        $playerCards = PlayerCard::query()
            ->where(['game_id' => $game->id])
            ->where(['player_id' => null])
            ->get();
        $count = $playerCards->count();

        if ($count) {
            $rand = random_int(0, $count - 1);
            $playerCard = $playerCards[$rand];
            $playerCard->player_id = $player;
            $playerCard->is_hidden = $isHidden;
            $playerCard->saveOrFail();

            return $playerCard;
        }

        return null;
    }
}