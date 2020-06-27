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
 * @UniqueEntity("nom", message="entity.groupe.unique")
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
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="anim_group")
     */
    private $user_group;

    /**
     * @ORM\OneToMany(targetEntity=Permanence::class, mappedBy="group_permanence")
     */
    private $permanences;

    public function __construct()
    {
        $this->user_group = new ArrayCollection();
        $this->permanences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserGroup(): Collection
    {
        return $this->user_group;
    }

    public function addUserGroup(User $userGroup): self
    {
        if (!$this->user_group->contains($userGroup)) {
            $this->user_group[] = $userGroup;
            $userGroup->setAnimGroup($this);
        }

        return $this;
    }

    public function removeUserGroup(User $userGroup): self
    {
        if ($this->user_group->contains($userGroup)) {
            $this->user_group->removeElement($userGroup);
            // set the owning side to null (unless already changed)
            if ($userGroup->getAnimGroup() === $this) {
                $userGroup->setAnimGroup(null);
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
            $permanences->setGroupPermanence($this);
        }

        return $this;
    }

    public function removePermanences(Permanence $permanences): self
    {
        if ($this->permanences->contains($permanences)) {
            $this->permanences->removeElement($permanences);
            // set the owning side to null (unless already changed)
            if ($permanences->getGroupPermanence() === $this) {
                $permanences->setGroupPermanence(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNom();
    }
}
