<?php

namespace Equip\Console\Command;

use Equip\Console\Exception\CommandException;
use Equip\Structure\Set;
use Symfony\Component\Console\Command\Command;

class CommandSet extends Set
{
    /**
     * {@inheritdoc}
     *
     * @throws CommandException If $commands does not extend the Command class
     */
    protected function assertValid(array $commands)
    {
        parent::assertValid($commands);

        foreach ($commands as $command) {
            if (!is_subclass_of($command, Command::class)) {
                throw CommandException::invalidCommand($command);
            }
        }
    }
}
