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
use App\Form\StuffChosenType;

class GameController extends AbstractController
{
    /**
     * @Route("/game/create", name="game.create")
     */
    public function create(BossRepository $bossRepository, SlotRepository $slotRepository, StuffRepository $stuffRepository)
    {       
        $session = new Session();
        $em = $this->getDoctrine()->getManager();  
        
        $game = new Game();
        $game->setUser($this->getUser());

        $randomBoss = $bossRepository->selectRandomBoss(); 
        $game->setBoss($randomBoss);

        $_slots = $slotRepository->findAll();
    
        $_stuff = [];
        $_exclude = [];
        foreach($_slots as $slot)
        {   
            $_stuff[$slot->getName()] = [];
            $_exclude[$slot->getId()] = [];
            
            for ($i = 0 ; $i < 3 ; $i++)
            {
                $_stuff[$slot->getName()][$i] = $stuffRepository->selectRandomStuffBySlot($slot, $_exclude[$slot->getId()]);
                $_exclude[$slot->getId()][] = $_stuff[$slot->getName()][$i]->getId();
            }  
        }

        $session->set('stuff', $_stuff);

        
        $em->persist($game);
        $em->flush();

        //dd($game);
        return $this->redirectToRoute('game', ['id' => $game->getId()]);
    }
  
    /**
     * @Route("/game/{id}", name="game", methods={"GET"})
     */

    public function index(Game $game, GameRepository $gameRepository){
             
        $game = $gameRepository->find($game->getId());
        $stuff = $this->get('session')->get('stuff');

        $form = $this->createForm(StuffChosenType::class);

        return $this->render('game/index.html.twig', [
            'game' => $game,
            'form' => $form->createView(),
            'stuff' => $stuff,  
        ]);
        
    }
}
