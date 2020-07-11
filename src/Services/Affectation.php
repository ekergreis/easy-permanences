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
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function initPermanences(Permanence $permanence): void
    {
        $uow = $this->em->getUnitOfWork();
        $uow->computeChangeSets();
        $entityChangeSet = $uow->getEntityChangeSet($permanence);

        if(!empty($entityChangeSet['group_permanence'])) {
            $oldGroup = $entityChangeSet['group_permanence'][0]->getId();
            if($oldGroup) {
                // Recherche des users de l'ancien group de la permanence
                $users = $this->em->getRepository(User::class)->findBy(['anim_group' => $oldGroup]);
                foreach ($users as $user) {
                    $this->delUserPermanence($user, $permanence);
                }
            }
        }
    }
    public function initUserGroupPermanences(User $user): void
    {
        $uow = $this->em->getUnitOfWork();
        $uow->computeChangeSets();
        $entityChangeSet = $uow->getEntityChangeSet($user);

        if(!empty($entityChangeSet['anim_group'])) {
            $oldGroup = $entityChangeSet['anim_group'][0]->getId();
            if($oldGroup) {
                // Recherche des permanences de l'ancien group du user
                $permanences = $this->em->getRepository(Permanence::class)->findBy(['group_permanence' => $oldGroup->getId()]);
                foreach ($permanences as $permanence) {
                    $this->delUserPermanence($user, $permanence);
                }
            }
        }
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