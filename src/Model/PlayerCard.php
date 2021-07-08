<?php


namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read id
 * @property int card_id
 * @property int player_id
 * @property int game_id
 * @property bool is_hidden
 * @property \DateTime created_at
 * @property \DateTime updated_at
 *
 * @property Game game
 * @property Player player
 */
class PlayerCard extends Model
{
    protected $table = 'players';

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'game_id');
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'player_id');
    }
}