<?php
namespace UMRA\Bundle\MemberBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class IndeterminateDateSubscriber implements EventSubscriberInterface
{
    /**
     * @var string
     * Name of date field to treat as indeterminate
     */
    private $dateField;

    /**
     * @var string
     * Name of boolean field to store indeterminate state of dateField's month.
     */
    private $monthIndeterminateField;

    /**
     * @var string
     * Name of boolean field to store indeterminate state of dateField's day.
     */
    private $dayIndeterminateField;

    public function __construct($dateField, $monthIndeterminateField, $dayIndeterminateField)
    {
        $this->dateField = $dateField;
        $this->monthIndeterminateField = $monthIndeterminateField;
        $this->dayIndeterminateField = $dayIndeterminateField;
    }

    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_bind
        // event and that the preBind method should be called.
        return array(FormEvents::PRE_BIND => 'preBind');
    }

    public function preBind(FormEvent $event)
    {
        $person = $event->getData();

        if (!empty($person[$this->dateField]['year']) && empty($person[$this->dateField]['day'])) {
            // Default to 1st the month for storage
            $person[$this->dateField]['day'] = 1;
            $person[$this->dayIndeterminateField] = true;

            if (empty($person[$this->dateField]['month'])) {
                // Default to january for storage
                $person[$this->dateField]['month'] = 1;
                $person[$this->monthIndeterminateField] = true;
            } else {
                $person[$this->monthIndeterminateField] = false;
            }
        } else {
            $person[$this->dayIndeterminateField] = false;
            $person[$this->monthIndeterminateField] = false;
        }

        $event->setData($person);
    }
}
