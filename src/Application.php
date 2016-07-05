<?php

namespace Equip\Console;

use Auryn\Injector;
use Equip\Configuration\ConfigurationSet;
use Equip\Console\Command\CommandSet;
use Symfony\Component\Console\Application as ConsoleApplication;

class Application
{
    /**
     * Create a new console application
     * 
     * @param Injector|null $injector
     * @param ConfigurationSet|null $configuration
     * @param CommandSet|null $commands
     * 
     * @return static
     */
    public static function build(
        Injector $injector = null,
        ConfigurationSet $configuration = null,
        CommandSet $commands = null
    ) {
        return new static(
            $injector,
            $configuration,
            $commands
        );
    }

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

    /**
     * @param Injector|null $injector
     * @param ConfigurationSet|null $configuration
     * @param CommandSet|null $commands
     */
    public function __construct(
        Injector $injector = null,
        ConfigurationSet $configuration = null,
        CommandSet $commands = null
    ) {
        $this->injector = $injector ?: new Injector;
        $this->configuration = $configuration ?: new ConfigurationSet;
        $this->commands = $commands ?: new CommandSet;
    }

    /**
     * Set configuration
     * 
     * @param array $configuration
     * 
     * @return $this
     */
    public function setConfiguration(array $configuration)
    {
        $this->configuration = $this->configuration->withValues($configuration);
        return $this;
    }
    
    /**
     * Set commands
     * 
     * @param array $commands
     * 
     * @return $this
     */
    public function setCommands(array $commands)
    {
        $this->commands = $this->commands->withValues($commands);
        return $this;
    }

    /**
     * Start the console application
     * 
     * @return int 0 if everything went fine, or an error code
     */
    public function run()
    {
        $this->configuration->apply($this->injector);
        
        $application = $this->injector->make(ConsoleApplication::class);
        
        array_map(function ($command) use ($application) {
            $application->add($this->injector->make($command));
        }, $this->commands->toArray());
        
        return $application->run();
    }
}
