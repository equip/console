<?php

namespace Equip\Console\Command;

use Equip\Console\Exception\CommandException;
use PHPUnit_Framework_TestCase as TestCase;

class CommandSetTest extends TestCase
{
    public function testAssertValidInvalid()
    {
        $this->setExpectedExceptionRegExp(
            CommandException::class,
            '/Command class `.*` must extend `.*`/'
        );
        
        $invalid_command = $this->createMock(CommandSet::class);
        
        new CommandSet([$invalid_command]);
    }
}
