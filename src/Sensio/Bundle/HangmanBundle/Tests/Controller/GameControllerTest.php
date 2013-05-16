<?php

namespace Sensio\Bundle\HangmanBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GameControllerTest extends WebTestCase
{
    private $client;

    protected function setUp()
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->client->followRedirects(true);
    }

    protected function tearDown()
    {
        $this->client = null;

        parent::tearDown();
    }

    // Write your functional test scenario here...
    public function testTryWord()
    {
        $crawler = $this->playWord('php');

        $this->assertEquals(
            'Congratulations!',
            $crawler->filter('#content > h2:first-child')->text()
        );
    }
    
    public function testTryInvalidWord()
    {
        $crawler = $this->playWord('java');

        $this->assertEquals(
            'Game Over!',
            $crawler->filter('#content > h2:first-child')->text()
        );
    }

    public function playWord($word) 
    {
        $crawler = $this->client->request('GET','/game/');
        $form = $crawler->selectButton('Let me guess...')->form();
        return $this->client->submit($form, array('word' => $word));
    }

    public function playLetter($letter)
    {
        $crawler = $this->client->getCrawler();
        $link = $crawler->selectLink($letter)->link();
        return $this->client->click($link);
    }    
    
    public function testTryWinLetterByLetter()
    {
        $crawler = $this->client->request('GET','/game/');

        $crawler = $this->playLetter('P');
        $crawler = $this->playLetter('X');
        $crawler = $this->playLetter('H');
        
        $this->assertEquals(
            'Congratulations!',
            $crawler->filter('#content > h2:first-child')->text()
        );
        
    }



}
