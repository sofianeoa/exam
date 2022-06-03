<?php

namespace App\Command;

use App\Entity\competition;
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
    name: 'competition:create',
    description: 'creation d une competition ',
)]
class competitionCreateCommand extends Command
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
            ->addOption('competitionName', null, InputOption::VALUE_REQUIRED, 'name of the competition')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle( $input, $output);

        if ($input->getOption('competitionName')) {
            $competitionName = $input->getOption(name: 'competitionName');
            $io->warning($competitionName);
        }

        
        $competition = new competition();
        $competition->setName($competitionName);

        $this->entityManager->persist($competition);
        $this->entityManager->flush();

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
