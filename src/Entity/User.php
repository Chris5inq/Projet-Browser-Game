<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="integer")
     */
    private $armour;

    /**
     * @ORM\Column(type="integer")
     */
    private $health;

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
     * @ORM\OneToMany(targetEntity="App\Entity\Fight", mappedBy="user", orphanRemoval=true)
     */
    private $fights;

    public function __construct()
    {
        $this->fights = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getHealth(): ?int
    {
        return $this->health;
    }

    public function setHealth(int $health): self
    {
        $this->health = $health;

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
     * @return Collection|Fight[]
     */
    public function getFights(): Collection
    {
        return $this->fights;
    }

    public function addFight(Fight $fight): self
    {
        if (!$this->fights->contains($fight)) {
            $this->fights[] = $fight;
            $fight->setUser($this);
        }

        return $this;
    }

    public function removeFight(Fight $fight): self
    {
        if ($this->fights->contains($fight)) {
            $this->fights->removeElement($fight);
            // set the owning side to null (unless already changed)
            if ($fight->getUser() === $this) {
                $fight->setUser(null);
            }
        }

        return $this;
    }
}
