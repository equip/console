<?php

namespace Equip\Console\Exception;

use DomainException;
use Symfony\Component\Console\Command\Command;

class CommandException extends DomainException
{
    /**
     * @param string|object $spec
     *
     * @return static
     */
    public static function invalidCommand($spec)
    {
        if (is_object($spec)) {
            $spec = get_class($spec);
        }

        return new static(sprintf(
            'Command class `%s` must extend `%s`',
            $spec,
            Command::class
        ));
    }
}
