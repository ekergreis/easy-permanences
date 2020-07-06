<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Entity\Permanence;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AdminEventSubscriber implements EventSubscriberInterface
{
    private $locator;

    public function __construct(ContainerInterface $locator)
    {
        $this->locator = $locator;
    }


    public function onPostUpdate($event, bool $remove = false)
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
            AfterEntityUpdatedEvent::class => 'onPostUpdate',
            AfterEntityPersistedEvent::class  => 'onPostUpdate',
            BeforeEntityDeletedEvent::class  => 'onPreDelete',
        ];
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
