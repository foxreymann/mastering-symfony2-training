<?php

namespace Sensio\Bundle\HangmanBundle\EventListener;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class PasswordEncoderListener
{
    private $passwordEncoder;

    public function __construct(PasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;    
    }


    public function prePersist(LifecycleEventArgs $event)
    {
        $event->getEntity()->encodePassword($this->passwordEncoder);       
    }

} 
