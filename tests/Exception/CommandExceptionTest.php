<?php

namespace Equip\Console\Exception;

use PHPUnit_Framework_TestCase as TestCase;
use Symfony\Component\Console\Command\Command;

class CommandExceptionTest extends TestCase
{
    public function testInvalidCommand()
    {
        $exception = CommandException::invalidCommand($this);

        $this->assertInstanceOf(CommandException::class, $exception);
        $this->assertRegExp(
            '/Command class `.*` must extend `.*`/',
            $exception->getMessage()
        );
    }
}
