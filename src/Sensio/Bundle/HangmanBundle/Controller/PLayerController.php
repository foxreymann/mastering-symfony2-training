<?php

namespace Sensio\Bundle\HangmanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\HangmanBundle\Entity\Player;
use Sensio\Bundle\HangmanBundle\Form\PlayerType;
use Symfony\Component\HttpFoundation\Request;

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
                $em = $this->getDoctrine()->getManager();
                $em->persist($player);
                $em->flush();

                return $this->redirect($this->generateUrl('hangman_game'));
            }
        }


        return array('form' => $form->createView());
    }

}
