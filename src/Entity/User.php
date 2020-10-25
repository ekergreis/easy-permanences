<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */

    private $id;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $mail;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $animRegulier;

    /**
     * @ORM\ManyToOne(targetEntity=Group::class, inversedBy="users")
     */
    private $group;

    /**
     * @ORM\ManyToMany(targetEntity=Permanence::class, mappedBy="users")
     */
    private $permanences;

    /**
     * @ORM\OneToMany(targetEntity=Echange::class, mappedBy="user", orphanRemoval=true)
     */
    private $echanges;

    /**
     * @ORM\OneToMany(targetEntity=EchangePropos::class, mappedBy="user", orphanRemoval=true)
     */
    private $echangePropos;

    public function __construct()
    {
        $this->permanences = new ArrayCollection();
        $this->echanges = new ArrayCollection();
        $this->echangePropos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param mixed $mail
     */
    public function setMail($mail): self
    {
        $this->mail = $mail;
        return $this;
    }

    public function getAnimRegulier(): ?bool
    {
        return $this->animRegulier;
    }

    public function setAnimRegulier(bool $animRegulier): self
    {
        $this->animRegulier = $animRegulier;
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
     * @return Collection|Permanence[]
     */
    public function getPermanences(): Collection
    {
        return $this->permanences;
    }

    public function addPermanence(Permanence $permanence): self
    {
        if (!$this->permanences->contains($permanence)) {
            $this->permanences[] = $permanence;
            $permanence->addUsers($this);
        }

        return $this;
    }

    public function removePermanence(Permanence $permanence): self
    {
        if ($this->permanences->contains($permanence)) {
            $this->permanences->removeElement($permanence);
            $permanence->removeUsers($this);
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
            $echange->setUser($this);
        }

        return $this;
    }

    public function removeEchange(Echange $echange): self
    {
        if ($this->echanges->contains($echange)) {
            $this->echanges->removeElement($echange);
            // set the owning side to null (unless already changed)
            if ($echange->getUser() === $this) {
                $echange->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EchangePropos[]
     */
    public function getEchangePropos(): Collection
    {
        return $this->echangePropos;
    }

    public function addEchangePropo(EchangePropos $echangePropo): self
    {
        if (!$this->echangePropos->contains($echangePropo)) {
            $this->echangePropos[] = $echangePropo;
            $echangePropo->setUser($this);
        }

        return $this;
    }

    public function removeEchangePropo(EchangePropos $echangePropo): self
    {
        if ($this->echangePropos->contains($echangePropo)) {
            $this->echangePropos->removeElement($echangePropo);
            // set the owning side to null (unless already changed)
            if ($echangePropo->getUser() === $this) {
                $echangePropo->setUser(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
