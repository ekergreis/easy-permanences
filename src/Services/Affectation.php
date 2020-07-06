<?php
namespace App\Services;

use App\Entity\User;
use App\Entity\Permanence;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Boolean;

class Affectation
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function setPermanences(Permanence $permanence, bool $remove): void
    {
        $group = $permanence->getGroupPermanence();
        if($group) {
            // Recherche des users du group de la permanence
            $users = $this->em->getRepository(User::class)->findBy(['anim_group' => $group->getId()]);
            foreach ($users as $user) {
                if($remove) {
                    $this->delUserPermanence($user, $permanence);
                } else {
                    $this->setUserPermanence($user, $permanence);
                }
            }
        }
    }

    public function setUserGroupPermanences(User $user, bool $remove): void
    {
        $group = $user->getAnimGroup();
        if($user->getAnimRegulier() && $group) {
            // Recherche des permanences du group du user
            $permanences = $this->em->getRepository(Permanence::class)->findBy(['group_permanence' => $group->getId()]);
            foreach ($permanences as $permanence) {
                if($remove) {
                    $this->delUserPermanence($user, $permanence);
                } else {
                    $this->setUserPermanence($user, $permanence);
                }
            }
        }
    }

    public function setUserPermanence(User $user, Permanence $permanence): void
    {
        $user->addPermanence($permanence);
        $this->em->persist($user);
        $this->em->flush();
    }
    public function delUserPermanence(User $user, Permanence $permanence): void
    {
        $user->removePermanence($permanence);
        $this->em->persist($user);
        $this->em->flush();
    }
}