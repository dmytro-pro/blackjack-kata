<?php


namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property-read id
 * @property string name
 * @property string suit
 * @property \DateTime created_at
 * @property \DateTime updated_at
 */
class Card extends Model
{
    protected $table = 'players';
}