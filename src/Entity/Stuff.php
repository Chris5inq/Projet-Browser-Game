<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StuffRepository")
 */
class Stuff
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $m_health;

    /**
     * @ORM\Column(type="integer")
     */
    private $m_armour;

    /**
     * @ORM\Column(type="integer")
     */
    private $m_resist_fire;

    /**
     * @ORM\Column(type="integer")
     */
    private $m_resist_ice;

    /**
     * @ORM\Column(type="integer")
     */
    private $m_power;

    /**
     * @ORM\Column(type="integer")
     */
    private $m_power_ice;

    /**
     * @ORM\Column(type="integer")
     */
    private $m_power_fire;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Game", mappedBy="stuffs")
     */
    private $Games;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Slot", inversedBy="stuffs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $slot;

    public function __construct()
    {
        $this->Games = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMHealth(): ?int
    {
        return $this->m_health;
    }

    public function setMHealth(int $m_health): self
    {
        $this->m_health = $m_health;

        return $this;
    }

    public function getMArmour(): ?int
    {
        return $this->m_armour;
    }

    public function setMArmour(int $m_armour): self
    {
        $this->m_armour = $m_armour;

        return $this;
    }

    public function getMResistFire(): ?int
    {
        return $this->m_resist_fire;
    }

    public function setMResistFire(int $m_resist_fire): self
    {
        $this->m_resist_fire = $m_resist_fire;

        return $this;
    }

    public function getMResistIce(): ?int
    {
        return $this->m_resist_ice;
    }

    public function setMResistIce(int $m_resist_ice): self
    {
        $this->m_resist_ice = $m_resist_ice;

        return $this;
    }

    public function getMPower(): ?int
    {
        return $this->m_power;
    }

    public function setMPower(int $m_power): self
    {
        $this->m_power = $m_power;

        return $this;
    }

    public function getMPowerIce(): ?int
    {
        return $this->m_power_ice;
    }

    public function setMPowerIce(int $m_power_ice): self
    {
        $this->m_power_ice = $m_power_ice;

        return $this;
    }

    public function getMPowerFire(): ?int
    {
        return $this->m_power_fire;
    }

    public function setMPowerFire(int $m_power_fire): self
    {
        $this->m_power_fire = $m_power_fire;

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGames(): Collection
    {
        return $this->Games;
    }

    public function addGame(Game $Game): self
    {
        if (!$this->Games->contains($Game)) {
            $this->Games[] = $Game;
            $Game->addStuff($this);
        }

        return $this;
    }

    public function removeGame(Game $Game): self
    {
        if ($this->Games->contains($Game)) {
            $this->Games->removeElement($Game);
            $Game->removeStuff($this);
        }

        return $this;
    }

    public function getSlot(): ?Slot
    {
        return $this->slot;
    }

    public function setSlot(?Slot $slot): self
    {
        $this->slot = $slot;

        return $this;
    }
}
