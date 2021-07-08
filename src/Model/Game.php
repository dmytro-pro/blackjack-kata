<?php


namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property-read id
 * @property int bank_player_id
 * @property \DateTime created_at
 * @property \DateTime updated_at
 *
 * @property Player bankPlayer
 * @property Player[]|Collection players
 */
class Game extends Model
{
    protected $table = 'games';

    public function bankPlayer(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'bank_player_id');
    }

    public function players(): HasMany
    {
        return $this->hasMany(Player::class, 'game_id');
    }
}