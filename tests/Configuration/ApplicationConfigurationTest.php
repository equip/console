<?php

namespace Equip\Console\Configuration;

use Auryn\Injector;
use PHPUnit_Framework_TestCase as TestCase;
use Symfony\Component\Console\Application;

class ApplicationConfigurationTest extends TestCase
{
    public function testApply()
    {
        $injector = $this->createMock(Injector::class);
        
        $injector->expects($this->once())
            ->method('define')
            ->with(
                Application::class,
                [
                    ':name' => 'Equip Console',
                    ':version' => '0.1',
                ]
            );
        
        $config = new ApplicationConfiguration;
        $config->apply($injector);
    }
}
