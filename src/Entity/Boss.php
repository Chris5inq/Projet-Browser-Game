<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BossRepository")
 */
class Boss
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $health;

    /**
     * @ORM\Column(type="integer")
     */
    private $armour;

    /**
     * @ORM\Column(type="integer")
     */
    private $resist_fire;

    /**
     * @ORM\Column(type="integer")
     */
    private $resist_ice;

    /**
     * @ORM\Column(type="integer")
     */
    private $power;

    /**
     * @ORM\Column(type="integer")
     */
    private $power_ice;

    /**
     * @ORM\Column(type="integer")
     */
    private $power_fire;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Game", mappedBy="boss")
     */
    private $games;

    public function __construct()
    {
        $this->games = new ArrayCollection();
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

    public function getHealth(): ?int
    {
        return $this->health;
    }

    public function setHealth(int $health): self
    {
        $this->health = $health;

        return $this;
    }

    public function getArmour(): ?int
    {
        return $this->armour;
    }

    public function setArmour(int $armour): self
    {
        $this->armour = $armour;

        return $this;
    }

    public function getResistFire(): ?int
    {
        return $this->resist_fire;
    }

    public function setResistFire(int $resist_fire): self
    {
        $this->resist_fire = $resist_fire;

        return $this;
    }

    public function getResistIce(): ?int
    {
        return $this->resist_ice;
    }

    public function setResistIce(int $resist_ice): self
    {
        $this->resist_ice = $resist_ice;

        return $this;
    }

    public function getPower(): ?int
    {
        return $this->power;
    }

    public function setPower(int $power): self
    {
        $this->power = $power;

        return $this;
    }

    public function getPowerIce(): ?int
    {
        return $this->power_ice;
    }

    public function setPowerIce(int $power_ice): self
    {
        $this->power_ice = $power_ice;

        return $this;
    }

    public function getPowerFire(): ?int
    {
        return $this->power_fire;
    }

    public function setPowerFire(int $power_fire): self
    {
        $this->power_fire = $power_fire;

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
            $game->setBoss($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->contains($game)) {
            $this->games->removeElement($game);
            // set the owning side to null (unless already changed)
            if ($game->getBoss() === $this) {
                $game->setBoss(null);
            }
        }

        return $this;
    }
}
