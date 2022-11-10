<?php
namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Service\MatchingService;
use App\Repository\CandidateRepository;

class MatchingTest extends KernelTestCase
{
    public function testMatchOffers(){
        // boot symfony kernel
        self::bootKernel();

        $container = static::getContainer();
        $candidateRepo = $container->get(candidateRepository::class);
        $matchingService = $container->get(MatchingService::class);
        $candidate = $candidateRepo->find(1);
        $candidateSkills = $candidate->getSkills();

        $matchingOffers = $matchingService->matchOffers($candidate);

        foreach ($matchingOffers as $matchingOffer){
            //pour chaque offres qui a match on recupère les skills demandés
            $matchedSkills = $matchingOffer->getSkills();
            foreach($matchedSkills as $mSkill){
                //pour chaque Skill des offres qui ont match on check la correspondance
                //avec les skills du candidat
                foreach ($candidateSkills as $cSkill){
                    //normalement il doit y avoir au moins une correspondance par offres

                    //TODO trouver un moyen de définir un minimum
                    //de skill qui correspondent pour pas avoir des faux-positifs
                    $this->assertEquals($cSkill, $mSkill);
                }
            }
        }




    }
}