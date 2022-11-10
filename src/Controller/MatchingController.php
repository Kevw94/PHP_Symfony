<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Repository\CandidateRepository;
use App\Repository\OfferRepository;
use App\Repository\SkillRepository;
use App\Service\MatchingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatchingController extends AbstractController
{

    #[Route('/matching/{id}')]
    public function matching(string $id, CandidateRepository $candidateRepository, MatchingService $matchingService)
    {
        $candidate = $candidateRepository->find($id);
        $skills = $candidate->getSkills();
        //dd($skills);

        $result = $matchingService->matchOffers($candidateRepository->find($id));

        return $this->render('matching/matching.html.twig',[
            'offers' => $result,
                'candidateId' => $id,
            ]
        );
    }
}