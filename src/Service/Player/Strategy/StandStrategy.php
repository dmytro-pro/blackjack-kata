<?php


namespace App\Service\Player\Strategy;

use App\Exception\BustException;
use App\Model\Game;
use App\Model\Player;
use App\Service\Distributor;
use App\Service\Player\PointsCalculator;

class StandStrategy
{
    /**
     * @var PointsCalculator
     */
    private $calculator;

    public function __construct(PointsCalculator $calculator)
    {
        $this->calculator = $calculator;
    }
    public function go(Game $game, Player $player): void
    {
        $playerCards = $player->getGameCards($game->id);
        $pointsCount = $this->calculator->calculatePoints($playerCards);

        if ($pointsCount > PointsCalculator::MAX_VALID_SUM) {
            throw new BustException();
        }
    }
}