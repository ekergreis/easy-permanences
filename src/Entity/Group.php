<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=GroupRepository::class)
 * @ORM\Table(name="`group`")
 * @UniqueEntity("name", message="entity.groupe.unique")
 */
class Group
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="group")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Permanence::class, mappedBy="group")
     */
    private $permanences;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->permanences = new ArrayCollection();
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
            $user->setGroup($this);
        }

        return $this;
    }

    public function removeUsers(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getGroup() === $this) {
                $user->setGroup(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Permanence[]
     */
    public function getPermanences(): Collection
    {
        return $this->permanences;
    }

    public function addPermanences(Permanence $permanences): self
    {
        if (!$this->permanences->contains($permanences)) {
            $this->permanences[] = $permanences;
            $permanences->setGroup($this);
        }

        return $this;
    }

    public function removePermanences(Permanence $permanences): self
    {
        if ($this->permanences->contains($permanences)) {
            $this->permanences->removeElement($permanences);
            // set the owning side to null (unless already changed)
            if ($permanences->getGroup() === $this) {
                $permanences->setGroup(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getname();
    }
}
