<?php


namespace App\Service\Player\Strategy;

use App\Exception\BustException;
use App\Model\Game;
use App\Model\Player;
use App\Service\Distributor;
use App\Service\Player\PointsCalculator;

// same as StandStrategy, but false-duplicated
// see https://www.goodreads.com/quotes/9579416-but-there-are-different-kinds-of-duplication-there-is-true
class ShowPointsStrategy
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