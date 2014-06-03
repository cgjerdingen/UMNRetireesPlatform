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

use Symfony\Component\Console\Output\OutputInterface;
use UMRA\Bundle\MemberBundle\Services\UserManipulator;

/**
 * @author Max Fierke <max@maxfierke.com>
 * @author Matthieu Bontemps <matthieu@knplabs.com>
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Luis Cordova <cordoval@gmail.com>
 * @author Lenar Lõhmus <lenar@city.ee>
 */
class PromoteMemberCommand extends RoleCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('umra:member:promote')
            ->setDescription('Promotes a member by adding a role')
            ->setHelp(<<<EOT
The <info>umra:member:promote</info> command promotes a member by adding a role

  <info>php app/console umra:member:promote fierk007@umn.edu ROLE_CUSTOM</info>
  <info>php app/console umra:member:promote --super fierk007@umn.edu</info>
EOT
            );
    }

    protected function executeRoleCommand(UserManipulator $manipulator, OutputInterface $output, $email, $super, $role)
    {
        if ($super) {
            $manipulator->promote($email);
            $output->writeln(sprintf('Member "%s" has been promoted as a super administrator.', $email));
        } else {
            if ($manipulator->addRole($email, $role)) {
                $output->writeln(sprintf('Role "%s" has been added to member "%s".', $role, $email));
            } else {
                $output->writeln(sprintf('Member "%s" did already have "%s" role.', $email, $role));
            }
        }
    }
}
