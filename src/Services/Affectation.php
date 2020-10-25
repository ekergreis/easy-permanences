<?php
namespace App\Services;

use App\Entity\Group;
use App\Entity\User;
use App\Entity\Permanence;
use Doctrine\ORM\EntityManagerInterface;

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

    /**
     * Les affectations de permanences des users de l'ancien groupe sont supprimés
     * si un changement de groupe est validé sur une permanence
     * @param Permanence $permanence
     */
    public function initPermanences(Permanence $permanence): void
    {
        $uow = $this->em->getUnitOfWork();
        $uow->computeChangeSets();
        $entityChangeSet = $uow->getEntityChangeSet($permanence);

        if (!empty($entityChangeSet['group'])) {
            // Chargement de l'ancien groupe
            $oldGroup = $entityChangeSet['group'][0];
            if ($oldGroup) {
                // Recherche des users de l'ancien group de la permanence
                foreach ($oldGroup->getUsers() as $user) {
                    $this->removeUserPermanence($user, $permanence);
                }
            }
        }
    }

    /**
     * Les affectations de permanences d'un user sont supprimés pour son ancien groupe
     * si un changement de groupe est validé sur un user
     * @param User $user
     */
    public function initUserGroupPermanences(User $user): void
    {
        $uow = $this->em->getUnitOfWork();
        $uow->computeChangeSets();
        $entityChangeSet = $uow->getEntityChangeSet($user);

        // Chargement de l'ancien groupe
        $oldGroupToRemove = $entityChangeSet['group'][0];
        // Si le user vient d'être passé en animateur régulier
        if (!empty($entityChangeSet['anim_regulier']) && $entityChangeSet['anim_regulier'][1]==false) {
            $oldGroupToRemove = $user->getGroup();
        }

        if (!empty($oldGroupToRemove)) {
            // Recherche des permanences de l'ancien group du user
            foreach ($oldGroupToRemove->getPermanences() as $permanence) {
                $this->removeUserPermanence($user, $permanence);
            }
        }
    }

    /**
     * Affectation/Suppression d'une permanence aux users du groupe sélectionné
     * @param Permanence $permanence
     * @param bool $remove : Cas suppresion permanence
     */
    public function setPermanences(Permanence $permanence, bool $remove): void
    {
        $group = $permanence->getGroup();
        if ($group) {
            // Recherche des users du group de la permanence
            foreach ($group->getUsers() as $user) {
                if ($remove) {
                    $this->removeUserPermanence($user, $permanence);
                } else {
                    $this->setUserPermanence($user, $permanence);
                }
            }
        }
    }

    /**
     * Affectation/Suppression pour un user des permanences lié à son groupe
     * @param User $user
     * @param bool $remove
     */
    public function setUserGroupPermanences(User $user, bool $remove): void
    {
        $group = $user->getGroup();
        if ($user->getAnimRegulier() && $group) {
            // Recherche des permanences du group du user
            foreach ($group->getPermanences() as $permanence) {
                if ($remove) {
                    $this->removeUserPermanence($user, $permanence);
                } else {
                    $this->setUserPermanence($user, $permanence);
                }
            }
        }
    }

    /**
     * Prépare la suppression d'un groupe annule les affectations
     * @param Group $group
     */
    public function removeGroup(Group $group): void
    {
        // Recherche des users et permanences du group
        foreach ($group->getUsers() as $user) {
            foreach ($group->getPermanences() as $permanence) {
                $this->removeUserPermanence($user, $permanence);
            }
            $group->removeUsers($user);
        }

        foreach ($group->getPermanences() as $permanence) {
            $group->removePermanences($permanence);
        }
    }


    /**
     * Ajoute une permanence à un user
     * @param User $user
     * @param Permanence $permanence
     */
    private function setUserPermanence(User $user, Permanence $permanence): void
    {
        $user->addPermanence($permanence);
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * Supprime une permanence à un user
     * @param User $user
     * @param Permanence $permanence
     */
    private function removeUserPermanence(User $user, Permanence $permanence): void
    {
        $user->removePermanence($permanence);
        $this->em->persist($user);
        $this->em->flush();
    }
}
