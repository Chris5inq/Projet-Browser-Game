<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $result;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $turns;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="Games")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Boss", inversedBy="Games")
     */
    private $boss;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Stuff", inversedBy="Games")
     */
    private $stuffs;

    public function __construct()
    {
        $this->stuffs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResult(): ?int
    {
        return $this->result;
    }

    public function setResult(int $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function getTurns(): ?int
    {
        return $this->turns;
    }

    public function setTurns(?int $turns): self
    {
        $this->turns = $turns;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getBoss(): ?Boss
    {
        return $this->boss;
    }

    public function setBoss(?Boss $boss): self
    {
        $this->boss = $boss;

        return $this;
    }

    /**
     * @return Collection|Stuff[]
     */
    public function getStuffs(): Collection
    {
        return $this->stuffs;
    }

    public function addStuff(Stuff $stuff): self
    {
        if (!$this->stuffs->contains($stuff)) {
            $this->stuffs[] = $stuff;
        }

        return $this;
    }

    public function removeStuff(Stuff $stuff): self
    {
        if ($this->stuffs->contains($stuff)) {
            $this->stuffs->removeElement($stuff);
        }

        return $this;
    }
}
