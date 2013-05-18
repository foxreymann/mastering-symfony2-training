<?php

namespace Sensio\Bundle\HangmanBundle\Game;

use Sensio\Bundle\HangmanBundle\Entity\GameDataRepository;
use Sensio\Bundle\HangmanBundle\Entity\Player;

class DatabaseGameContext
{
    private $repository;

    private $player;

    public function __construct(GameDataRepository $repository, Player $player)
    {
        $this->repository  = $repository;
        $this->player = $player;
    }

    public function reset()
    {
        $this->repository->reset($this->player, array());
    }

    public function newGame($word)
    {
        return new Game($word);
    }

    public function loadGame()
    {
        $data = $this->repository->find($this->player);

        if (null === $data || !count($data)) {
            return false;
        }

        return new Game(
            $data['word'],
            $data['attempts'],
            $data['tried_letters'],
            $data['found_letters']
        );
    }

    public function save(Game $game)
    {
        $this->repository->save($this->player, $game->getContext());
    }
}
