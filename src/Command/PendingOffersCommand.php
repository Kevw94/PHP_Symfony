<?php
namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use App\Service\OfferService;
use App\Entity\Offer;
use App\Repository\OfferRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Input\ConsoleInputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

#[AsCommand(
    name:'app:pending_offers',
    description:"returns a list of offers which doesn't have a registered candidate (pending offers)",
    hidden: false,
    aliases: ['app:p_off','a:po'],
)]
class PendingOffersCommand extends Command
{
    private $offerManager;

    public function __construct(OfferService $offerManager)
    {
        $this->offerManager = $offerManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command returns a list 
            of all pending offers in db with their 
            respective ids and description')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
{
        $pendingOffers = $this->offerManager->findPendingOffers();
        $output->writeln([
            ' ',
            ' Pending Offers ',
            '=================',
            ' ',
        ]);
        foreach ($pendingOffers as $offer){
            $desc = $offer->getDescription();
            $id = $offer->getId();
            $output->writeln([
                " ",
                $output->write([
                    $id,
                    " : ",
                    $desc, 
                ])
            ]);
        }
        return Command::SUCCESS;
}}