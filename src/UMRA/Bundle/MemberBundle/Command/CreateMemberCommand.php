<?php

/*
 * This file is based on a part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UMRA\Bundle\MemberBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use UMRA\Bundle\MemberBundle\Entity\Email;
use UMRA\Bundle\MemberBundle\Entity\Household;
use UMRA\Bundle\MemberBundle\Entity\Person;

/**
 * @author Max Fierke <max@maxfierke.com>
 * @author Matthieu Bontemps <matthieu@knplabs.com>
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Luis Cordova <cordoval@gmail.com>
 */
class CreateMemberCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('umra:member:create')
            ->setDescription('Create an UMRA member.')
            ->setDefinition(array(
                new InputArgument('email', InputArgument::REQUIRED, 'Member email'),
                new InputArgument('fullname', InputArgument::REQUIRED, 'Member full name'),
                new InputArgument('password', InputArgument::REQUIRED, 'Member password'),
                new InputOption('super-admin', null, InputOption::VALUE_NONE, 'Set the member as super admin'),
                new InputOption('inactive', null, InputOption::VALUE_NONE, 'Set the member as inactive'),
            ))
            ->setHelp(<<<EOT
The <info>umra:member:create</info> command creates a member:

  <info>php app/console fos:member:create fierk007@umn.edu</info>

This interactive shell will ask you for a full name, and then a password.

You can alternatively specify the full name and password as the second and third arguments:

  <info>php app/console fos:member:create fierk007@umn.edu "Max Fierke" mypassword</info>

You can create a super admin via the super-admin flag:

  <info>php app/console fos:member:create fierk007@umn.edu --super-admin</info>

You can create an inactive member (will not be able to log in):

  <info>php app/console fos:member:create fierk007@umn.edu --inactive</info>

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email      = $input->getArgument('email');
        $fullname   = $input->getArgument('fullname');
        $password   = $input->getArgument('password');
        $active   = !$input->getOption('inactive');
        $superadmin = $input->getOption('super-admin');

        $userManager = $this->getContainer()->get('fos_user.user_manager');
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $user = $userManager->createUser();

        $nameTokens = explode(" ", $fullname);

        $user->setFullname($fullname);
        $user->setPostalname($fullname);
        $user->setFirstname($nameTokens[0]);
        $user->setNickname($nameTokens[0]);
        $user->setNametagname($nameTokens[0]);
        $user->setLastname($nameTokens[count($nameTokens) - 1]);
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setEnabled((Boolean) $active);
        $user->setSuperAdmin((Boolean) $superadmin);
        $userManager->updateUser($user, true);

        $objEmail = new Email();
        $objEmail->setEmail($email);
        $objEmail->setType('personal');
        $objEmail->setPerson($user);
        $objEmail->setPreferred(true);
        $em->persist($objEmail);

        $household = new Household();
        $household->setLastname($nameTokens[1]);
        $household->setFirstname($nameTokens[0]);
        $household->setPostalname($fullname);
        $em->persist($household);

        $em->flush();

        $user->setHousehold($household);
        $userManager->updateUser($user, true);

        $output->writeln(sprintf('Created member <comment>%s</comment>', $fullname));
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('email')) {
            $email = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose an email:',
                function($email) {
                    if (empty($email)) {
                        throw new \Exception('Email can not be empty');
                    }

                    return $email;
                }
            );
            $input->setArgument('email', $email);
        }

        if (!$input->getArgument('fullname')) {
            $fullname = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose an fullname:',
                function($fullname) {
                    if (empty($fullname)) {
                        throw new \Exception('Fullname can not be empty');
                    }

                    $nameTokens = explode(" ", $fullname);

                    if(count($nameTokens) != 2 && count($nameTokens) != 3) {
                        throw new \Exception("Fullname must contain a first name, last name, and optionally a middle name");
                    }

                    return $fullname;
                }
            );
            $input->setArgument('fullname', $fullname);
        }

        if (!$input->getArgument('password')) {
            $password = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a password:',
                function($password) {
                    if (empty($password)) {
                        throw new \Exception('Password can not be empty');
                    }

                    return $password;
                }
            );
            $input->setArgument('password', $password);
        }
    }
}
