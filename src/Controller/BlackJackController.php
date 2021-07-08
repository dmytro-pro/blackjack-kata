<?php


namespace App\Controller;


use App\Exception\BustException;
use App\Exception\NoCardsLeftException;
use App\Model\Card;
use App\Model\Game;
use App\Model\Player;
use App\Model\PlayerCard;
use App\Service\Distributor;
use App\Service\Player\Strategy\HitStrategy;
use App\Service\Player\PointsCalculator;
use App\Service\Player\Strategy\ShowPointsStrategy;
use App\Service\Player\Strategy\StandStrategy;
use Illuminate\Support\Facades\Auth;

class BlackJackController
{
    /**
     * @var Distributor
     */
    private $distributor;

    /**
     * @var HitStrategy
     */
    private $hitStrategy;

    /**
     * @var PointsCalculator
     */
    private $pointsCalculator;

    /**
     * @var StandStrategy
     */
    private $standStrategy;

    /**
     * @var ShowPointsStrategy
     */
    private $showPointsStrategy;

    public function __construct(
        Distributor $distributor,
        PointsCalculator $pointsCalculator,
        HitStrategy $hitStrategy,
        StandStrategy $standStrategy,
        ShowPointsStrategy $showPointsStrategy
    )
    {
        $this->distributor = $distributor;
        $this->pointsCalculator = $pointsCalculator;
        $this->hitStrategy = $hitStrategy;
        $this->standStrategy = $standStrategy;
        $this->showPointsStrategy = $showPointsStrategy;
    }

    public function newGame()
    {
        PlayerCard::query()->where('game_id', 1)->delete();

        $cards = Card::query()->get();
        /** @var Card $card */
        foreach ($cards as $card) {
            PlayerCard::create([
                'card_id' => $card->id,
                'player_id' => null,
                'is_hidden' => false,
            ]);
        }

        /** @var Game $game */
        $game = Game::query()->findOrFail(1);
        $gamePlayers = $game->players;
        /** @var Player $gamePlayer */
        foreach ($gamePlayers as $gamePlayer) {
            $this->distributor->hit($game, $gamePlayer, false);
            $this->distributor->hit($game, $gamePlayer, false);
        }

        $this->distributor->hit($game, $game->bankPlayer, false);
        $this->distributor->hit($game, $game->bankPlayer, true);

        return [
            'status' => 'OK',
            'caption' => 'New game started',
            'game_id' => 1,
        ];
    }

    public function hit()
    {
        /** @var Player $player */
        $player = Auth::guard('player')->user();

        /** @var Game $game */
        $game = Game::query()->findOrFail(1);

        try {
            $this->hitStrategy->go($game, $player);

            return [
                'status' => 'OK',
                'caption' => 'Good to go',
                'player_points_count' => $this->pointsCalculator->calculatePoints($player->getGameCards($game->id)),
                'game_id' => 1,
            ];
        } catch (BustException $exception) {
            return [
                'status' => 'BUST',
                'caption' => 'Player is bust',
                'player_points_count' => $this->pointsCalculator->calculatePoints($player->getGameCards($game->id)),
                'game_id' => 1,
            ];
        } catch (NoCardsLeftException $exception) {
            return [
                'status' => 'NO_CARDS_LEFT',
                'caption' => 'No Cards Left to hit, use Stand strategy instead',
                'player_points_count' => $this->pointsCalculator->calculatePoints($player->getGameCards($game->id)),
                'game_id' => 1,
            ];
        }
    }


    public function stand()
    {
        /** @var Player $player */
        $player = Auth::guard('player')->user();

        /** @var Game $game */
        $game = Game::query()->findOrFail(1);

        try {
            $this->standStrategy->go($game, $player);

            return [
                'status' => 'OK',
                'caption' => 'Good to go',
                'player_points_count' => $this->pointsCalculator->calculatePoints($player->getGameCards($game->id)),
                'game_id' => 1,
            ];
        } catch (BustException $exception) {
            return [
                'status' => 'BUST',
                'caption' => 'Player is bust',
                'player_points_count' => $this->pointsCalculator->calculatePoints($player->getGameCards($game->id)),
                'game_id' => 1,
            ];
        }
    }

    public function showMyPoints()
    {
        /** @var Player $player */
        $player = Auth::guard('player')->user();

        /** @var Game $game */
        $game = Game::query()->findOrFail(1);

        try {
            $this->showPointsStrategy->go($game, $player);

            return [
                'status' => 'OK',
                'caption' => 'Good to go',
                'player_points_count' => $this->pointsCalculator->calculatePoints($player->getGameCards($game->id)),
                'game_id' => 1,
            ];
        } catch (BustException $exception) {
            return [
                'status' => 'BUST',
                'caption' => 'Player is bust',
                'player_points_count' => $this->pointsCalculator->calculatePoints($player->getGameCards($game->id)),
                'game_id' => 1,
            ];
        }
    }

    public function showBankPoints()
    {
        /** @var Player $player */
        $player = Auth::guard('player')->user();

        /** @var Game $game */
        $game = Game::query()->findOrFail(1);

        try {
            $this->showPointsStrategy->go($game, $game->bankPlayer);

            return [
                'status' => 'OK',
                'caption' => 'Good to go',
                'bank_points_count' => $this->pointsCalculator->calculatePoints($player->getGameCards($game->id)),
                'game_id' => 1,
            ];
        } catch (BustException $exception) {
            return [
                'status' => 'BUST',
                'caption' => 'Bank is bust',
                'bank_points_count' => $this->pointsCalculator->calculatePoints($player->getGameCards($game->id)),
                'game_id' => 1,
            ];
        }
    }
}