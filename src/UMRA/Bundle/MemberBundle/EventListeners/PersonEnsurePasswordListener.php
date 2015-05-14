<?php

namespace UMRA\Bundle\MemberBundle\EventListeners;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use UMRA\Bundle\MemberBundle\Entity\Person;

class PersonEnsurePasswordListener implements EventSubscriber
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getSubscribedEvents()
    {
        return array(
            Events::prePersist,
        );
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($entity instanceof Person) {
            $plainPassword = $entity->getPlainPassword();

            if (!empty($plainPassword)) {
                // User already has a password. Nothing to do.
                return;
            }

            if (function_exists("openssl_random_pseudo_bytes")) {
                $entity->setPlainPassword(openssl_random_pseudo_bytes(12));
            } else {
                // Less than secure randomized password generation
                // Luckily, plainPassword gets bcrypt()'d
                $this->logger->warning("OpenSSL extension not loaded." .
                                 "Falling back to using uniqid() for ranomized plain-text password generation." .
                                 "Password will still be hashed.");
                $entity->setPlainPassword(uniqid(mt_rand()));
            }
        }
    }
}
