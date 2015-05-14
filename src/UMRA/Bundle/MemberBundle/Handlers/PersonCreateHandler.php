<?php

namespace UMRA\Bundle\MemberBundle\Handlers;

use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Doctrine\UserManager;
use FOS\UserBundle\Util\TokenGenerator;
use Psr\Log\LoggerInterface;
use UMRA\Bundle\MemberBundle\Entity\Email;
use UMRA\Bundle\MemberBundle\Entity\Person;

class PersonCreateHandler
{
    private $em;
    private $userManager;
    private $tokenGenerator;
    private $logger;

    public function __construct(ObjectManager $em, UserManager $userManager, TokenGenerator $tokenGenerator, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->userManager = $userManager;
        $this->tokenGenerator = $tokenGenerator;
        $this->logger = $logger;
    }

    public function process($member, $andFlush = true, $overrideHousehold = null)
    {
        $emailCanonical = $member->getEmailCanonical();

        if (!empty($emailCanonical)) {
            $email = new Email();
            $email->setType("personal");
            $email->setPreferred(true);
            $email->setPerson($member);
            $email->setEmail($emailCanonical);
            $this->em->persist($email);

            $member->setEmailCanonical($emailCanonical);
            $member->setConfirmationToken($this->tokenGenerator->generateToken());
        }

        $member->setActivenow(false);

        if ($overrideHousehold !== null) {
            $member->setHousehold($overrideHousehold);
        }

        $this->userManager->updateUser($member, $andFlush);

        return $member;
    }
}