<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * @Route("/game/greate", name="game.create")
     */
    public function create()
    {
        
        
        
        return $this->render('game/index.html.twig', [
            'controller_name' => 'GameController',
        ]);
    }
}
