<?php

namespace Sensio\Bundle\HangmanBundle\Tests\Game;

use Sensio\Bundle\HangmanBundle\Game\Game;

class GameTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideCorrectWord
     */
    public function provideCorrectWords()
    {
        return array(
            array('php'),
            array('java'),
            array('ruby')
        );
    }

    /**
     * @dataProvider provideCorrectWords
     */
    public function testTryCorrectWord($word) 
    {
        $game = new Game($word);

        $this->assertTrue($game->tryWord($word));
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

    public function testTryCorrectLetter()
    {
        $game = new Game('php');
        $this->assertTrue($game->tryLetter('p'));
        $this->assertSame(Game::MAX_ATTEMPTS, $game->getRemainingAttempts());
        $this->assertFalse($game->isWon());
        $this->assertFalse($game->isHanged());
        $this->assertFalse($game->isOver());
    }

    public function testTryIncorrectLetter()
    {
        $game = new Game('php');
        $this->assertFalse($game->tryLetter('j'));
        $this->assertSame(Game::MAX_ATTEMPTS - 1, $game->getRemainingAttempts());
        $this->assertFalse($game->isWon());
        $this->assertFalse($game->isHanged());
        $this->assertFalse($game->isOver());
    }

    public function testTrySameCorrectLetterTwice()
    {
        $game = new Game('php');
        $this->assertTrue($game->tryLetter('p'));
        $this->assertFalse($game->tryLetter('p'));
        $this->assertSame(Game::MAX_ATTEMPTS - 1, $game->getRemainingAttempts());
        $this->assertFalse($game->isWon());
        $this->assertFalse($game->isHanged());
        $this->assertFalse($game->isOver());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testTryNumber()
    {
        $game = new Game('php');
        $game->tryLetter('4');
    }

}
