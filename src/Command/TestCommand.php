<?php
namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Input\ConsoleInputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

#[AsCommand(
    name:'app:test',
    description:'this is a test',
    hidden: false,
    aliases: ['app:base-test'],
)]
class TestCommand extends Command
{
    protected function configure(): void
    {
        $this
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to create a user...')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
{
        // outputs multiple lines to the console (adding "\n" at the end of each line)

        //fetch toutes les offres qui n'ont pas de candidat retenu (toutes les offres à pourvoir) ou qui ont un status empty
        $output->writeln([
            'TEST TEST',
            '============',
            'Whoa!',
            'You are about to Test',
        ]);
        return Command::SUCCESS;
}}