<?php

namespace App\Command;

namespace App\Command;
            
use App\Repository\TeamRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'teamName:Change',
    description: 'changement du nom de la team',
)]
class TeamNameChangeCommand extends Command
{
    protected function configure(): void
    {
        $this
        ->addOption('name', null, InputOption::VALUE_REQUIRED, 'EDIT')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $name = $input ->getOption('name');
        $Team = $this->TeamRepository->find($name);

        if ($Team) {
            $TeamName = $io->ask('nouveau nom de la team:', $Team->getName());
            $Team->setName($TeamName);

                $this->entityManager->persist($Team);
                #enregistrer
                $this->entityManager->flush();
                #appliquer les modifs
        }
        else {
            $io->error('la team n existe pas ');
            return Command::FAILURE;
        
        }
        $io->success(('vous avez une nouvelle team'));
        return Command::SUCCESS;
    }
}
