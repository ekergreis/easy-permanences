<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Entity\Permanence;
use EasyCorp\Bundle\EasyAdminBundle\Event;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AdminEventSubscriber implements EventSubscriberInterface
{
    private $locator;

    public function __construct(ContainerInterface $locator)
    {
        $this->locator = $locator;
    }

    public function onPreUpdate($event)
    {
        $this->initHook($event);
    }

    public function onPostUpdate($event)
    {
        $this->traitHook($event, false);
    }

    public function onPreDelete($event)
    {
        $this->traitHook($event, true);
    }

    public static function getSubscribedEvents()
    {
        return [
            Event\BeforeEntityUpdatedEvent::class  => 'onPreUpdate',
            Event\BeforeEntityDeletedEvent::class  => 'onPreDelete',
            Event\AfterEntityUpdatedEvent::class => 'onPostUpdate',
            Event\AfterEntityPersistedEvent::class  => 'onPostUpdate',
        ];
    }

    private function initHook($event)
    {
        $entity = $event->getEntityInstance();
        if($entity instanceof Permanence) {
            $affect = $this->locator->get('app.affectation');
            $affect->initPermanences($entity);
        }
        if($entity instanceof User) {
            $affect = $this->locator->get('app.affectation');
            $affect->initUserGroupPermanences($entity);
        }
    }

    private function traitHook($event, $remove)
    {
        $entity = $event->getEntityInstance();
        if($entity instanceof Permanence) {
            $affect = $this->locator->get('app.affectation');
            $affect->setPermanences($entity, $remove);
        }
        if($entity instanceof User) {
            $affect = $this->locator->get('app.affectation');
            $affect->setUserGroupPermanences($entity, $remove);
        }
    }
}
