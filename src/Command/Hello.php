<?php

namespace Equip\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Hello extends Command
{
    protected function configure()
    {
        $this
            ->setName('hello')
            ->setDescription('Example command')
            ->addArgument(
                'name',
                InputArgument::OPTIONAL,
                'Who do you want to say hello to?'
            );
    }

    public function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $name = $input->getArgument('name') ?: 'world';

        $output->writeln(sprintf('Hello, %s!', $name));
    }
}
