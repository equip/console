<?php

namespace Equip\Console;

use Auryn\Injector;
use Equip\Configuration\ConfigurationSet;
use Equip\Console\Command\CommandSet;
use Equip\Console\Command\Hello;
use Equip\Console\Configuration\ApplicationConfiguration;
use PHPUnit_Framework_TestCase as TestCase;
use ReflectionObject;
use Symfony\Component\Console\Application as ConsoleApplication;

class ApplicationTest extends TestCase
{
    /**
     * @var Injector
     */
    private $injector;

    /**
     * @var ConfigurationSet
     */
    private $configuration;

    /**
     * @var CommandSet
     */
    private $commands;

    protected function setUp()
    {
        $this->injector = $this->createMock(Injector::class);
        $this->configuration = $this->createMock(ConfigurationSet::class);
        $this->commands = $this->createMock(CommandSet::class);
    }

    private function assertApplication($app)
    {
        $app_object = new ReflectionObject($app);

        $props = [
            'injector' => Injector::class,
            'configuration' => ConfigurationSet::class,
            'commands' => CommandSet::class,
        ];

        foreach ($props as $name => $expected) {
            $prop = $app_object->getProperty($name);
            $prop->setAccessible(true);
            $value = $prop->getValue($app);

            if ($expected) {
                $this->assertInstanceOf($expected, $value, $name);
            }
        }
    }

    public function testBuild()
    {
        $app = Application::build();

        $this->assertApplication($app);
    }

    public function testCreate()
    {
        $app = new Application(
            $this->injector,
            $this->configuration,
            $this->commands
        );

        $this->assertApplication($app);
    }

    public function testSetConfiguration()
    {
        $config = [ApplicationConfiguration::class];

        $this->configuration
            ->expects($this->once())
            ->method('withValues')
            ->with($config);

        Application::build(
            $this->injector,
            $this->configuration,
            $this->commands
        )->setConfiguration($config);
    }

    public function testSetCommands()
    {
        $commands = [Hello::class];

        $this->commands
            ->expects($this->once())
            ->method('withValues')
            ->with($commands);

        Application::build(
            $this->injector,
            $this->configuration,
            $this->commands
        )->setCommands($commands);
    }

    public function testRun()
    {
        $application = $this->getMockBuilder(ConsoleApplication::class)
            ->setMethods(['run', 'add'])
            ->getMock();

        $application
            ->expects($this->once())
            ->method('run');

        $application
            ->expects($this->once())
            ->method('add')
            ->with(new Hello);

        $this->configuration
            ->expects($this->once())
            ->method('apply')
            ->with($this->injector);

        $this->injector
            ->expects($this->exactly(2))
            ->method('make')
            ->will($this->onConsecutiveCalls(
                $application,
                new Hello
            ));

        $this->commands
            ->expects($this->any())
            ->method('toArray')
            ->willReturn([Hello::class]);

        Application::build(
            $this->injector,
            $this->configuration,
            $this->commands
        )->run();
    }
}
