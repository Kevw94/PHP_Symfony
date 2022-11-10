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
    aliases: ['app:p_off'],
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
            ->setHelp('This command returns a list of all pending offers in db')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
{
        // outputs multiple lines to the console (adding "\n" at the end of each line)

        //fetch toutes les offres qui n'ont pas de candidat retenu 
        //(toutes les offres à pourvoir) ou qui ont un status empty
        $pendingOffers = $this->offerManager->findPendingOffers();
        // foreach ($pendingOffers as $offers){
        //     $finalString = $finalString.$offers.id;
        // }
        // $output->writeln([$finalString]);
        $output->writeln([
            ' Pending Offers ',
            '=================',
        ]);
        foreach ($pendingOffers as $offers){
            // $desc = $offers->getDescription;
            $desc = $this->offerManager->getOfferDescription($offers);
                $output->writeln([
                    $desc
                    //write la desc de chaque élément
                ]);
            //il trouve bien 2 offres
            //comment afficher la desc pour chaque offres
            // $output->writeln([
            //     $pendingOffers[0]
            // ]);
        }
        
        


        return Command::SUCCESS;
}}