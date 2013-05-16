<?php

namespace Sensio\Bundle\HangmanBundle\Tests\Game;

use Sensio\Bundle\HangmanBundle\Game\Game;

class GameTest extends \PHPUnit_Framework_TestCase
{
    public function testTryCorrectWord() 
    {
        $game = new Game('php');

        $this->assertTrue($game->tryWord('php'));
        $this->assertTrue($game->isWon());
        $this->assertFalse($game->isHanged());
        $this->assertTrue($game->isOver());
        $this->assertSame(Game::MAX_ATTEMPTS,$game->getRemainingAttempts());
    }

    public function testTryInvalidWord()
    {
        $game = new Game('php');
        $this->assertFalse($game->tryWord('java'));
        $this->assertFalse($game->isWon());
        $this->assertTrue($game->isHanged());
        $this->assertTrue($game->isOver());
        $this->assertSame(0,$game->getRemainingAttempts());
    }
    
}
