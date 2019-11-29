<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Game;
use App\Repository\BossRepository;
use App\Repository\GameRepository;
use App\Repository\SlotRepository;
use App\Repository\StuffRepository;
use App\Form\StuffChosenType;
use Symfony\Component\HttpFoundation\Request;

class GameController extends AbstractController
{
    /**
     * @Route("/game/create", name="game.create")
     */
    public function create(BossRepository $bossRepository, SlotRepository $slotRepository, StuffRepository $stuffRepository)
    {       
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

        $this->get('session')->set('stuff', $_stuff);

        
        $em->persist($game);
        $em->flush();

        //dd($game);
        return $this->redirectToRoute('game', ['id' => $game->getId()]);
    }
  
    /**
     * @Route("/game/{id}", name="game", methods={"GET", "POST"})
     */

    public function index(Game $game, GameRepository $gameRepository, Request $request){
             
        $game = $gameRepository->find($game->getId());

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
     */

    public function result(Game $game)
    {
        $type[0]['damage'] = "Power";
        $type[0]['resist'] = "Armour";
        $type[0]['name'] = "la Force brute";

        $type[1]['damage'] = "PowerFire";
        $type[1]['resist'] = "ResistFire";
        $type[1]['name'] = "le Feu";

        $type[2]['damage'] = "PowerIce";
        $type[2]['resist'] = "ResistIce";
        $type[2]['name'] = "la Glace";
        
        
        $_modifs['Armour'] = 0;
        $_modifs['Resistfire'] = 0;
        $_modifs['ResistIce'] = 0;
        $_modifs['Power'] = 0;
        $_modifs['PowerFire'] = 0;
        $_modifs['PowerIce'] = 0;
   
        foreach($this->get('session')->get('stuff_chosen') as $slot => $stuff)
        {
            $_modifs['Armour'] += $stuff->getMArmour();
            $_modifs['Resistfire'] += $stuff->getMResistFire();
            $_modifs['ResistIce'] += $stuff->getMResistIce();
            $_modifs['Power'] += $stuff->getMPower();
            $_modifs['PowerFire'] += $stuff->getMPowerFire();
            $_modifs['PowerIce'] += $stuff->getMPowerIce();
        }
        
        $_caracs['real_Armour'] = $game->getUser()->getArmour() + $_modifs['Armour'];
        $_caracs['real_ResistFire'] = $game->getUser()->getResistFire() + $_modifs['Resistfire'];
        $_caracs['real_ResistIce'] = $game->getUser()->getResistIce() + $_modifs['ResistIce'];
        $_caracs['real_Power'] = $game->getUser()->getPower() + $_modifs['Power'];
        $_caracs['real_PowerFire'] = $game->getUser()->getPowerFire() + $_modifs['PowerFire'];
        $_caracs['real_PowerIce'] = $game->getUser()->getPowerIce() + $_modifs['PowerIce'];
        
        $HealthHero = $game->getUser()->getHealth();
        $HealthBoss = $game->getBoss()->getHealth();

        $turns = array();
        $t = 0;
        while($HealthHero > 0 && $HealthBoss > 0 )
        {
            $t++;
            
            $dam_ch = rand(0,2);
            $DamageHero = max(0, $_caracs['real_'.$type[$dam_ch]['damage']] - $game->getBoss()->{'get'.$type[$dam_ch]['resist']}());
            $HealthBoss -= $DamageHero;

            $turns[$t]['Hero']['type'] = $type[$dam_ch]['name'];
            $turns[$t]['Hero']['damages'] = $DamageHero;
            $turns[$t]['Hero']['health'] = $HealthBoss;

            if($HealthBoss <= 0)
            {
                $result = 1;
                break;
            }

            $dam_ch = rand(0,2);
            $DamageBoss =  max(0, $game->getBoss()->{'get'.$type[$dam_ch]['damage']}() - $_caracs['real_'.$type[$dam_ch]['resist']]);
            $HealthHero -= $DamageBoss;

            $turns[$t]['Boss']['type'] = $type[$dam_ch]['name'];
            $turns[$t]['Boss']['damages'] = $DamageBoss;
            $turns[$t]['Boss']['health'] = $HealthHero;

            if($HealthHero <= 0)
            {
                $result = 0;
            }
 
        }

        $game->setResult($result);
        $game->setTurns($t);
        $em = $this->getDoctrine()->getManager();
        $em->persist($game);
        $em->flush();
        
        $stuff_chosen = $this->get('session')->get('stuff_chosen');
        
        return $this->render('game/result.html.twig', [
            'game' => $game,
            'stuff_chosen' => $stuff_chosen,
            'turns' => $turns
        ]);   

    }
}
