<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Form\Type\OfferType;
use App\Repository\CandidateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OfferRepository;


class OfferController extends AbstractController
{
    const STATUS_ONLINE = "online";
    const STATUS_OFFLINE = self::OFFLINE;
    const OFFLINE = 'offline';
    const CLOSE = 'close';

    #[Route('/offer', name: 'app_offer', methods: ['GET'])]
    public function index(OfferRepository $offerRepository): Response
    {
        $offers = $offerRepository->findOfferByStatus('online');

        return $this->render('offer/index.html.twig', [
            'offers' => $offers,
            'controller_name' => 'OfferController',
        ]);
    }

    #[Route('/offer/create', name: 'create_offer')]
    public function create_offer(Request $request, OfferRepository $offerRepository): Response
    {
        $newOffer = new Offer();

        $newOffer->setStatus(self::STATUS_ONLINE);

        $form = $this->createForm(OfferType::class, $newOffer);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newOffer = $form->getData();
            $offerRepository->save($newOffer, true);
            return $this->redirectToRoute('app_offer');
        }

        return $this->renderForm('offer/new.html.twig', [
            'form' => $form,
        ]);
    }


    #[Route('/offer/edit/{id}', name: 'offer_edit')]
    public function editOffer(OfferRepository $offerRepository, Request $request, int $id): Response
    {
        $editOffer = $offerRepository->find($id);

        $form = $this->createForm(OfferType::class, $editOffer);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $editOffer = $form->getData();
            $offerRepository->save($editOffer, true);
            return $this->redirectToRoute('app_offer');
        }

        return $this->renderForm('offer/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/offer/{id}/{companyId}', name: 'offer_candidates')]
    public function offerCandidates(int $id,int $companyId, OfferRepository $offerRepository): Response
    {
        $offer = $offerRepository->find($id);

        $offerCandidacies = $offer->getCandidacies();

        return $this->render('offer/candidates.html.twig', [
            'candidacies' => $offerCandidacies,
            'controller_name' => 'OfferController',
            'companyId' => $companyId
        ]);

    }

    #[Route('/offer/{id}/candidate/{idUser}/{companyId}', name: 'validate_candidate')]
    public function validateCandidate(int $id, int $idUser, int $companyId, OfferRepository $offerRepository, CandidateRepository $candidateRepository): Response
    {
        $editOffer = $offerRepository->find($id);
        $editOffer = $editOffer->setStatus(self::OFFLINE);
        $offerRepository->save($editOffer, true);

        $editCandidate = $candidateRepository->find($idUser);
        $editCandidate = $editCandidate->setStatus(self::CLOSE);
        $candidateRepository->save($editCandidate, true);


        return $this->redirectToRoute('app_mailer', array('id' => $id, 'idUser' => $idUser, 'companyId' => $companyId));
    }
}


