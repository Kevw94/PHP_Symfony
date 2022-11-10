<?php

namespace App\Controller;

use App\Entity\Candidacy;
use App\Repository\CandidacyRepository;
use App\Repository\CandidateRepository;
use App\Repository\OfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApplyController extends AbstractController
{
    #[Route('/apply/{candidateId}/{offerId}', name: 'app_apply')]
    public function index(int $offerId, int $candidateId, CandidacyRepository $candidacyRepository, CandidateRepository $candidateRepository, OfferRepository $offerRepository): Response
    {
        $newCandidacy = new Candidacy();
        $candidate = $candidateRepository->find($candidateId);
        $offer = $offerRepository->find($offerId);

        $offer = $offer->setStatus('applied');
        $offerRepository->save($offer,true);

        $newCandidacy->setIdUser($candidate);
        $newCandidacy->setOffer($offer);

        $candidacyRepository->save($newCandidacy, true);
        return $this->render('apply/index.html.twig', [
            'controller_name' => 'ApplyController',
        ]);
    }
}
