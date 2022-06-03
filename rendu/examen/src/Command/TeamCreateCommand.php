<?php

namespace App\Command;

use App\Entity\Team;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'Team:create',
    description: 'creation d une team ',
)]
class TeamCreateCommand extends Command
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager , ?string $name = null)
    {
        parent::__construct($name);
        $this->entityManager = $entityManager;
    }
    protected function configure(): void
    {
        $this
            #->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('TeamName', null, InputOption::VALUE_REQUIRED, 'name of the team')
            ->addOption('TeamCity', null, InputOption::VALUE_REQUIRED, 'name of the City')
            ->addOption('TeamColor', null, InputOption::VALUE_REQUIRED, 'name of the color')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle( $input, $output);

        if ($input->getOption('TeamName')) {
            $TeamName = $input->getOption(name: 'TeamName');
            $io->warning($TeamName);
        }
        if ($input->getOption('TeamCity')) {
            $TeamCity = $input->getOption(name: 'TeamCity');
            $io->warning($TeamCity);
        }
        if ($input->getOption('TeamColor')) {
            $TeamColor = $input->getOption(name: 'TeamColor');
            $io->warning($TeamColor);
        }
        
        $Team = new Team();
        $Team->setName($TeamName);
        $Team->setCity($TeamCity);
        $Team->setCity($TeamColor);

        $this->entityManager->persist($Team);
        $this->entityManager->flush();

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
