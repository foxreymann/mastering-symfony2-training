<?php

namespace Sensio\Bundle\HangmanBundle\Test\EventListener;

use Sensio\Bundle\HangmanBundle\EventListener\PasswordEncoderListener;

class PasswordEncoderListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testItEncodesThePassword()
    {
        $encoder = $this->getMock('Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface');

        $player = $this->getMock('Sensio\Bundle\HangmanBundle\Entity\Player');
        $player->expects($this->once())
            ->method('encodePassword')
            ->with($encoder);

        $event = $this->getMockBuilder('Doctrine\Common\Persistence\Event\LifecycleEventArgs')
            ->disableOriginalConstructor()
            ->getMock();
        $event->expects($this->once())
            ->method('getEntity')
            ->will($this->returnValue($player));
        
        $listener = new PasswordEncoderListener($encoder);
        $listener->prePersist($event);
    }
}
