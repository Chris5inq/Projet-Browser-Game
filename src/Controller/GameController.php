<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Game;
use App\Repository\BossRepository;
use App\Repository\GameRepository;
use App\Repository\SlotRepository;
use App\Repository\StuffRepository;
use Symfony\Component\HttpFoundation\Session\Session;

class GameController extends AbstractController
{
    /**
     * @Route("/game/create", name="game.create")
     */
    public function create(BossRepository $bossRepository, SlotRepository $slotRepository, StuffRepository $stuffRepository)
    {       
        $session = new Session(); 
        $session->start(); 
        
        $game = new Game();
        $game->setUser($this->getUser());

        $randomBoss = $bossRepository->selectRandomBoss(); 
        $game->setBoss($randomBoss);

        $_slots = $slotRepository->findAll();
    
        $_stuff = [];
        $_exclude = [];
        foreach($_slots as $slot)
        {   
            $_stuff[$slot->getId()] = [];
            $_exclude[$slot->getId()] = [];
            
            for ($i = 0 ; $i < 3 ; $i++)
            {
                $_stuff[$slot->getId()][$i] = $stuffRepository->selectRandomStuffBySlot($slot, $_exclude[$slot->getId()]);
                $_exclude[] = $_stuff[$slot->getId()][$i]->getId();
            }  
        }

        $session->set('stuff', $_stuff);

        $em = $this->getDoctrine()->getManager();
        $em->persist($game);
        $em->flush();

        //dd($game);
        return $this->redirectToRoute('game', ['id' => $game->getId()]);
    }
  
    /**
     * @Route("/game/{id}", name="game", methods={"GET"})
     */

    public function index(Game $game, GameRepository $gameRepository){
             
        //dd($game);
        $game = $gameRepository->find($game->getId());

        $session = new Session(); 
        $session->start(); 

        return $this->render('game/index.html.twig', [
            'game' => $game,
            'stuff' => $session->get('stuff')  
        ]);
        
    }
}
