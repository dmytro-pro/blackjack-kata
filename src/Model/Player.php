<?php


namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property-read id
 * @property \DateTime created_at
 * @property \DateTime updated_at
 */
class Player extends Model
{
    protected $table = 'players';

    /**
     * @param int $gameId
     * @return \Illuminate\Database\Eloquent\Collection|PlayerCard[]
     */
    public function getGameCards(int $gameId)
    {
        return PlayerCard::query()
            ->where(['player_id' => $this->id])
            ->where(['game_id' => $gameId])
            ->get();
    }
}