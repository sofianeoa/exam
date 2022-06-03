<?php


namespace App\Command;

use App\Repository\TeamRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


#[AsCommand(
    name: 'Team:list',
    description: 'lister les teams',
)]
class TeamListCommand extends Command
{
    private $TeamRepository;

    public function __construct(TeamRepository $TeamRepository, string $name = null)
    {
        parent::__construct($name);
        $this->TeamRepository=$TeamRepository ;
    }

    protected function configure(): void
    {
        $this
            ->addOption('Team', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $teams = $this->TeamRepository->findAll();

        $table = new Table($output);
        $table->setHeaders(['City','color','name']);

        foreach ($teams as $team) {
            $table->addRow([$team->getCity(), $team->getColor(), $team->getName()]);
        }
        $table->render();
        
        return Command::SUCCESS;
    }
}
