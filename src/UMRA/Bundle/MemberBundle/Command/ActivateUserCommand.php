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
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Max Fierke <max@maxfierke.com>
 * @author Antoine Hérault <antoine.herault@gmail.com>
 */
class ActivateUserCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('umra:member:activate')
            ->setDescription('Activate a member')
            ->setDefinition(array(
                new InputArgument('email', InputArgument::REQUIRED, 'The email'),
            ))
            ->setHelp(<<<EOT
The <info>umra:member:activate</info> command activates a member (so they will be able to log in):

  <info>php app/console umra:member:activate matthieu</info>
EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');

        $manipulator = $this->getContainer()->get('umra_member.user_manipulator');
        $manipulator->activate($email);

        $output->writeln(sprintf('Member "%s" has been activated.', $email));
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('email')) {
            $email = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a email:',
                function($email) {
                    if (empty($email)) {
                        throw new \Exception('Email can not be empty');
                    }

                    return $email;
                }
            );
            $input->setArgument('email', $email);
        }
    }
}
