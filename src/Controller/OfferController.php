<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Form\Type\OfferType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OfferRepository;


class OfferController extends AbstractController
{
    const STATUS_ONLINE = "online";
    const STATUS_OFFLINE = "offline";

    #[Route('/offer', name: 'app_offer', methods: ['GET'])]
    public function index(OfferRepository $offerRepository): Response
    {
        $offers = $offerRepository->findAll();

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
}
