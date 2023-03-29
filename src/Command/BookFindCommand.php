<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:book:find',
    description: 'Command to find a book'
)]
class BookFindCommand extends Command
{
    protected static $defaultName;
    protected static $defaultDescription;
    protected function configure()
    {
        $this
            ->addArgument('lastname', InputArgument::REQUIRED, 'Your lastname')
            ->addArgument('firstname', InputArgument::REQUIRED|InputArgument::IS_ARRAY, 'Your firstname')
            ->addOption('gender',  null,InputOption::VALUE_OPTIONAL, description: 'Your gender')
            // --no-gender  -->
            //->addOption('gender',  null,InputOption::VALUE_NEGATABLE, description: 'Your gender')
            // pass multiple options to gender -->
            //->addOption('gender',  null,InputOption::VALUE_IS_ARRAY, description: 'Your gender')
        ;

    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $firstname = $input->getArgument('firstname');
        $lastname = $input->getArgument('lastname');
        $gender = $input->getOption('gender');

        $io->note(sprintf("We found the book you searched is: %s ", $lastname));
        if ($firstname) {
            $io->text(sprintf("We found the book you searched is: %s ", implode(', ', $firstname)));
        }
        if ($gender) {
            $io->info(sprintf("You passed a gender: %s", $gender));
        }
        $io->success('It\'s alive!');

        return Command::SUCCESS;
    }
}