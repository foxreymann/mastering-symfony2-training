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

    public function testRemainingAttempts()
    {
        $game = new Game('php');
 

    }
    
}
