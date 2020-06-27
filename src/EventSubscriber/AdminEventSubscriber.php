<?php

namespace App\EventSubscriber;

use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AdminEventSubscriber implements EventSubscriberInterface
{
    public function onPreUpdate($event)
    {
        dump($event);die;
    }

    public static function getSubscribedEvents()
    {
        return [
            EasyAdminEvents::PRE_UPDATE => 'onPreUpdate',
        ];
    }
}
