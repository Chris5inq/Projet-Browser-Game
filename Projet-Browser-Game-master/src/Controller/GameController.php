<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Game;
use App\Repository\BossRepository;
use App\Form\StuffChosenType;
use App\Service\GameCreation;
use App\Service\GameResolution;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class GameController extends AbstractController
{
    /**
     * @Route("/game/create", name="game.create")
     * @IsGranted({"ROLE_USER"})
     */
    public function create(BossRepository $bossRepository, GameCreation $gameCreation)
    {       
        $em = $this->getDoctrine()->getManager();  
        
        $game = new Game();
        $game->setUser($this->getUser());

        $randomBoss = $bossRepository->selectRandomBoss(); 
        $game->setBoss($randomBoss);

        $_random_stuff = $gameCreation->selectRandomStuff();
        $this->get('session')->set('stuff', $_random_stuff);

        $em->persist($game);
        $em->flush();

        //dd($game);
        return $this->redirectToRoute('game.stuff', ['id' => $game->getId()]);
    }
  
    /**
     * @Route("/game/stuff/{id}", name="game.stuff", methods={"GET", "POST"})
     * @IsGranted({"ROLE_USER"})
     */

    public function choseStuff(Game $game, Request $request){
             
        //$game = $gameRepository->find($game->getId());

        $form = $this->createForm(StuffChosenType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->get('session')->set('stuff_chosen', $form->getData());

            return $this->redirectToRoute('game.result', ['id' => $game->getId()]);
        }

        return $this->render('game/index.html.twig', [
            'game' => $game,
            'form' => $form->createView(),
        ]);
        
    }

    /**
     * @Route("/game/result/{id}", name="game.result", methods={"GET"})
     * @IsGranted({"ROLE_USER"})
     */

    public function result(Game $game, GameResolution $gameResolution)
    {
        $stuff_chosen = $this->get('session')->get('stuff_chosen');
        [$game, $turns] = $gameResolution->resolveFight($game, $stuff_chosen);

        $em = $this->getDoctrine()->getManager();
        $em->persist($game);
        $em->flush();
        
        
        
        return $this->render('game/result.html.twig', [
            'game' => $game,
            'stuff_chosen' => $stuff_chosen,
            'turns' => $turns
        ]);   

    }
}
