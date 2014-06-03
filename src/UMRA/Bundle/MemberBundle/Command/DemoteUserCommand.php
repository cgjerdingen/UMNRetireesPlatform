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
 * @author Antoine Hérault <antoine.herault@gmail.com>
 * @author Lenar Lõhmus <lenar@city.ee>
 */
class DemoteUserCommand extends RoleCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('umra:member:demote')
            ->setDescription('Demote a member by removing a role')
            ->setHelp(<<<EOT
The <info>umra:member:demote</info> command demotes a member by removing a role

  <info>php app/console umra:member:demote fierk007@umn.edu ROLE_CUSTOM</info>
  <info>php app/console umra:member:demote --super fierk007@umn.edu</info>
EOT
            );
    }

    protected function executeRoleCommand(UserManipulator $manipulator, OutputInterface $output, $email, $super, $role)
    {
        if ($super) {
            $manipulator->demote($email);
            $output->writeln(sprintf('Member "%s" has been demoted as a simple member.', $email));
        } else {
            if ($manipulator->removeRole($email, $role)) {
                $output->writeln(sprintf('Role "%s" has been removed from member "%s".', $role, $email));
            } else {
                $output->writeln(sprintf('Member "%s" didn\'t have "%s" role.', $email, $role));
            }
        }
    }
}
