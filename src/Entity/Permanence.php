<?php

namespace App\Entity;

use App\Repository\PermanenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PermanenceRepository::class)
 */
class Permanence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Group::class, inversedBy="permanences")
     */
    private $group;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="permanences")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Echange::class, mappedBy="permanence", orphanRemoval=true)
     */
    private $echanges;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->echanges = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getGroup(): ?Group
    {
        return $this->group;
    }

    public function setGroup(?Group $group): self
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUsers(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUsers(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }

    /**
     * @return Collection|Echange[]
     */
    public function getEchanges(): Collection
    {
        return $this->echanges;
    }

    public function addEchange(Echange $echange): self
    {
        if (!$this->echanges->contains($echange)) {
            $this->echanges[] = $echange;
            $echange->setPermanence($this);
        }

        return $this;
    }

    public function removeEchange(Echange $echange): self
    {
        if ($this->echanges->contains($echange)) {
            $this->echanges->removeElement($echange);
            // set the owning side to null (unless already changed)
            if ($echange->getPermanence() === $this) {
                $echange->setPermanence(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getDate()->format('d/m/Y');
    }
}
