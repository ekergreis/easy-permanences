<?php

namespace App\EventSubscriber;

use App\Entity\Group;
use App\Entity\User;
use App\Entity\Permanence;
use EasyCorp\Bundle\EasyAdminBundle\Event;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AdminEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    private $locator;

    /**
     * AdminEventSubscriber constructor.
     * @param ContainerInterface $locator
     */
    public function __construct(ContainerInterface $locator)
    {
        $this->locator = $locator;
    }

    /**
     * @param $event
     */
    public function onPreUpdate($event)
    {
        $this->initHook($event);
    }

    /**
     * @param $event
     */
    public function onPostUpdate($event)
    {
        $this->traitHook($event, false);
    }

    /**
     * @param $event
     */
    public function onPreDelete($event)
    {
        $this->traitHook($event, true);
    }

    /**
     * Souscription aux évènements
     * @return array|string[]
     */
    public static function getSubscribedEvents()
    {
        return [
            Event\BeforeEntityUpdatedEvent::class  => 'onPreUpdate',
            Event\BeforeEntityDeletedEvent::class  => 'onPreDelete',
            Event\AfterEntityUpdatedEvent::class => 'onPostUpdate',
            Event\AfterEntityPersistedEvent::class  => 'onPostUpdate',
        ];
    }

    /**
     * Reinitialisation si un de changement groupe est réalisé (user / permanence)
     * @param $event
     */
    private function initHook($event)
    {
        $entity = $event->getEntityInstance();
        // Initialisation avant mise à jour Permanence
        if($entity instanceof Permanence) {
            $affect = $this->locator->get('app.affectation');
            $affect->initPermanences($entity);
        }
        // Initialisation avant mise à jour User
        if($entity instanceof User) {
            $affect = $this->locator->get('app.affectation');
            $affect->initUserGroupPermanences($entity);
        }
    }

    /**
     * Changement groupe sur user / permanence : Affectation user / permanence
     * @param $event
     * @param $remove
     */
    private function traitHook($event, $remove)
    {
        $entity = $event->getEntityInstance();
        // Mise à jour Permanence
        if($entity instanceof Permanence) {
            $affect = $this->locator->get('app.affectation');
            $affect->setPermanences($entity, $remove);
        }
        // Mise à jour User
        if($entity instanceof User) {
            $affect = $this->locator->get('app.affectation');
            $affect->setUserGroupPermanences($entity, $remove);
        }
        // Suppression Group
        if($entity instanceof Group && $remove) {
            $affect = $this->locator->get('app.affectation');
            $affect->removeGroup($entity, $remove);
        }
    }
}
