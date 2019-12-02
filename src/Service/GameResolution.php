<?php

namespace App\Service;

use App\Entity\Game;

class GameResolution
{
    
    public function resolveFight(Game $game, $stuff_chosen)
    {
        // Création d'un tableau indiquant quelles caracs fonctionnent par paires (Force, Feu, Glace,...)
        $type[0]['damage'] = "Power";
        $type[0]['resist'] = "Armour";
        $type[0]['name'] = "la Force brute";

        $type[1]['damage'] = "PowerFire";
        $type[1]['resist'] = "ResistFire";
        $type[1]['name'] = "le Feu";

        $type[2]['damage'] = "PowerIce";
        $type[2]['resist'] = "ResistIce";
        $type[2]['name'] = "la Glace";
        
        // Création d'un tableau qui comprendra le total des modificateurs sur chaque carac en fonction du stuff choisi
        $_modifs['Armour'] = 0;
        $_modifs['Resistfire'] = 0;
        $_modifs['ResistIce'] = 0;
        $_modifs['Power'] = 0;
        $_modifs['PowerFire'] = 0;
        $_modifs['PowerIce'] = 0;
   
        // Ajout des modificateurs
        foreach($stuff_chosen as $stuff)
        {
            $_modifs['Armour'] += $stuff->getMArmour();
            $_modifs['Resistfire'] += $stuff->getMResistFire();
            $_modifs['ResistIce'] += $stuff->getMResistIce();
            $_modifs['Power'] += $stuff->getMPower();
            $_modifs['PowerFire'] += $stuff->getMPowerFire();
            $_modifs['PowerIce'] += $stuff->getMPowerIce();
        }
        
        // Calcul des caracs de Hero en prenant en compte les modificateurs
        $_caracs['real_Armour'] = $game->getUser()->getArmour() + $_modifs['Armour'];
        $_caracs['real_ResistFire'] = $game->getUser()->getResistFire() + $_modifs['Resistfire'];
        $_caracs['real_ResistIce'] = $game->getUser()->getResistIce() + $_modifs['ResistIce'];
        $_caracs['real_Power'] = $game->getUser()->getPower() + $_modifs['Power'];
        $_caracs['real_PowerFire'] = $game->getUser()->getPowerFire() + $_modifs['PowerFire'];
        $_caracs['real_PowerIce'] = $game->getUser()->getPowerIce() + $_modifs['PowerIce'];
        
        // Intiialisation des points de vie de Hero/du Boss
        $HealthHero = $game->getUser()->getHealth();
        $HealthBoss = $game->getBoss()->getHealth();

        // Résolution de chaque tour
        $turns = array();
        $t = 0;
        while($HealthHero > 0 && $HealthBoss > 0 )
        {
            $t++;
            
            // Choix aléatoire de la carac utilisée pour l'attaque de Hero
            $dam_ch = rand(0,2);
            
            // Attaque de Hero, retrait des points de vie du Boss
            $DamageHero = max(0, $_caracs['real_'.$type[$dam_ch]['damage']] - $game->getBoss()->{'get'.$type[$dam_ch]['resist']}());
            $HealthBoss -= $DamageHero;

            // "Log" de l'actuion dans les infos du tour 
            $turns[$t]['Hero']['type'] = $type[$dam_ch]['name'];
            $turns[$t]['Hero']['damages'] = $DamageHero;
            $turns[$t]['Hero']['HealthBoss'] = $HealthBoss;

            // Teste si Boss a survécu
            if($HealthBoss <= 0)
            {
                $result = 1;
                break;
            }

            // Choix aléatoire de la carac utilisée pour l'attaque du Boss
            $dam_ch = rand(0,2);
            
            // Attaque du Boss, retrait des points de vie de Hero
            $DamageBoss =  max(0, $game->getBoss()->{'get'.$type[$dam_ch]['damage']}() - $_caracs['real_'.$type[$dam_ch]['resist']]);
            $HealthHero -= $DamageBoss;

            // "Log" de l'actuion dans les infos du tour 
            $turns[$t]['Boss']['type'] = $type[$dam_ch]['name'];
            $turns[$t]['Boss']['damages'] = $DamageBoss;
            $turns[$t]['Boss']['HealthHero'] = $HealthHero;

            // Teste si Hero a survécu
            if($HealthHero <= 0)
            {
                $result = 0;
            }
        }

        $game->setResult($result);
        $game->setTurns($t);
        
        return [$game, $turns];
    }
}
