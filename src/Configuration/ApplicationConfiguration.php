<?php

namespace Equip\Console\Configuration;

use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;
use Symfony\Component\Console\Application;

class ApplicationConfiguration implements ConfigurationInterface
{
    public function apply(Injector $injector)
    {
        $injector->define(Application::class, [
            ':name' => 'Equip Console',
            ':version' => '0.1',
        ]);
    }
}
