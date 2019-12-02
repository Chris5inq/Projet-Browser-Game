<?php

namespace App\Service;

use App\Repository\SlotRepository;
use App\Repository\StuffRepository;

class GameCreation
{
    private $slotRepo;
    private $stuffRepo;

    public function __construct(SlotRepository $slotRepository, StuffRepository $stuffRepository)
    {
        $this->slotRepo = $slotRepository;
        $this->stuffRepo = $stuffRepository;   
    }
    
    public function selectRandomStuff()
    {
        $_slots = $this->slotRepo->findAll();
    
        $_random_stuff = [];
        $_exclude = [];
        
        
        foreach($_slots as $slot)
        {   
            $_random_stuff[$slot->getName()] = [];
            $_exclude[$slot->getId()] = [];
            
            // Pour chaque slot existant, récupération de 3 stuffs au hasard parmi les existants, en excluant ceux déjà choisis
            for ($i = 0 ; $i < 3 ; $i++)
            {
                $_random_stuff[$slot->getName()][$i] = $this->stuffRepo->selectRandomStuffBySlot($slot, $_exclude[$slot->getId()]);
                $_exclude[$slot->getId()][] = $_random_stuff[$slot->getName()][$i]->getId();
            }  
        }
        return $_random_stuff;
    }   
}
