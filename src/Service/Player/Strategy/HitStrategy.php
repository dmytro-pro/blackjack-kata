<?php


namespace App\Service\Player\Strategy;

use App\Exception\BustException;
use App\Exception\NoCardsLeftException;
use App\Model\Game;
use App\Model\Player;
use App\Model\PlayerCard;
use App\Service\Distributor;
use App\Service\Player\PointsCalculator;

class HitStrategy
{
    /**
     * @var PointsCalculator
     */
    private $calculator;

    /**
     * @var Distributor
     */
    private $distributor;

    public function __construct(PointsCalculator $calculator, Distributor $distributor)
    {
        $this->calculator = $calculator;
        $this->distributor = $distributor;
    }
    public function go(Game $game, Player $player): PlayerCard
    {
        $playerCards = $player->getGameCards($game->id);
        $pointsCount = $this->calculator->calculatePoints($playerCards);

        if ($pointsCount > PointsCalculator::MAX_VALID_SUM) {
            throw new BustException();
        }

        $card = $this->distributor->hit($game, $player, false);

        if (!$card) {
            throw new NoCardsLeftException();
        }

        $pointsCount = $this->calculator->calculatePoints($playerCards);
        if ($pointsCount > PointsCalculator::MAX_VALID_SUM) {
            throw new BustException();
        }

        return $card;
    }
}