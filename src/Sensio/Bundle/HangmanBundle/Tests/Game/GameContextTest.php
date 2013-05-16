<?php

namespace Sensio\Bundle\HangmanBundle\Tests\Game;

use Sensio\Bundle\HangmanBundle\Game\GameContext;
use Sensio\Bundle\HangmanBundle\Game\Game;

class GameContextTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadTheGame() 
    {
        $data = array(
            'word' => 'php',
            'attempts' => 3,
            'tried_letters' => array('p','x'),
            'found_letters' => array('p')
        );

        $session = $this->getMockBuilder('Symfony\Component\HttpFoundation\Session\Session')  
            ->setMethods(array('get'))
            ->getMock();

        $session->expects($this->once())
            ->method('get')
            ->with('hangman', array())
            ->will($this->returnValue($data));

        $context = new GameContext($session);

        $this->assertInstanceOf('Sensio\Bundle\HangmanBundle\Game\Game', $context->loadGame());
    }

    public function testCantLoadTheGame() 
    {
        $session = $this->getMockBuilder('Symfony\Component\HttpFoundation\Session\Session')  
            ->setMethods(array('get'))
            ->getMock();

        $session->expects($this->once())
            ->method('get')
            ->with('hangman', array())
            ->will($this->returnValue(null));

        $context = new GameContext($session);

        $this->assertFalse(false, $context->loadGame());
    }

    public function testSaveGame()
    {
        $data = array(
            'word' => 'php',
            'attempts' => 3,
            'tried_letters' => array('p','x'),
            'found_letters' => array('p')
        );

        $session = $this->getMockBuilder('Symfony\Component\HttpFoundation\Session\Session')  
            ->setMethods(array('set'))
            ->getMock();

        $session->expects($this->once())
            ->method('set')
            ->with('hangman', $data);

        $game = $this->getMockBuilder('Sensio\Bundle\HangmanBundle\Game\Game')  
            ->disableOriginalConstructor()
            ->setMethods(array('getContext'))
            ->getMock();

        $game->expects($this->once())
            ->method('getContext')
            ->will($this->returnValue($data));

        $context = new GameContext($session);

        $this->assertNull($context->save($game));
    }

}
