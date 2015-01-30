<?php
namespace UMRA\Bundle\MemberBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class IndeterminateDateSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_bind
        // event and that the preBind method should be called.
        return array(FormEvents::PRE_BIND => 'preBind');
    }

    public function preBind(FormEvent $event)
    {
        $person = $event->getData();

        if (empty($person['ustartdate']['day'])) {
            // Default to 1 of the month for storage
            $person['ustartdate']['day'] = 1;
            $person['ustartDayIndeterminate'] = true;

            if (empty($person['ustartdate']['month'])) {
                // Default to january for storage
                $person['ustartdate']['month'] = 1;
                $person['ustartMonthIndeterminate'] = true;
            } else {
                $person['ustartMonthIndeterminate'] = false;
            }
        } else {
            $person['ustartDayIndeterminate'] = false;
            $person['ustartMonthIndeterminate'] = false;
        }

        if (empty($person['uretiredate']['day'])) {
            $person['uretiredate']['day'] = 1;
            $person['uretireDayIndeterminate'] = true;

            if (empty($person['uretiredate']['month'])) {
                $person['uretiredate']['month'] = 1;
                $person['uretireMonthIndeterminate'] = true;
            } else {
                $person['uretireMonthIndeterminate'] = false;
            }
        } else {
            $person['uretireDayIndeterminate'] = false;
            $person['uretireMonthIndeterminate'] = false;
        }

        $event->setData($person);
    }
}
