<?php

require __DIR__ . '/vendor/autoload.php';

Equip\Console\Application::build()
->setConfiguration([
    Equip\Console\Configuration\ApplicationConfiguration::class,
])
->setCommands([
    Equip\Console\Command\Hello::class,
])
->run();
