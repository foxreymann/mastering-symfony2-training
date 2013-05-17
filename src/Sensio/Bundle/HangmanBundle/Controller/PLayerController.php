<?php

namespace Sensio\Bundle\HangmanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\HangmanBundle\Entity\Player;
use Sensio\Bundle\HangmanBundle\Form\PlayerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class PLayerController extends Controller
{
    /**
     * @Route("/signup", name="signup")
     * @Template()
     */
    public function signupAction(Request $request)
    {
        $player = new Player();
        $form = $this->createForm(new PlayerType(), $player);

        if($request->isMethod('post')) {
            $form->bind($request);
            if($form->isValid()) {
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($player);
                $player->encodePassword($encoder);
                $em = $this->getDoctrine()->getManager();
                $em->persist($player);
                $em->flush();

                return $this->redirect($this->generateUrl('hangman_game'));
            }
        }


        return array('form' => $form->createView());
    }


    /**
     * @Route("/login", name="signin")
     * @Template()
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        if($name = $session->get(SecurityContext::LAST_USERNAME)) {
            $session->remove(SecurityContext::LAST_USERNAME);
        }

        if($error = $session->get(SecurityContext::AUTHENTICATION_ERROR))
        { 
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return array('last_username' => $name, 'error' => $error);
    }

    /**
     * @Template()
     * @Cache(smaxage=120)
     */
    public function playersAction($max)
    { 
        $repository = $this->getDoctrine()->getRepository('SensioHangmanBundle:Player');
        $players = $repository->findRecentPlayers($max);

        return array('players' => $players);
    }
}
