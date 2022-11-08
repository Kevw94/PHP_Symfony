<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Form\Type\OfferType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OfferRepository;
use App\Service\OfferService;
use Doctrine\Persistence\ManagerRegistry;


class OfferController extends AbstractController
{
    #[Route('/offer', name: 'app_offer')]
    public function index(OfferService $myService, ManagerRegistry $doctrine): Response
    {
		$message = $myService->TryFindAllOffers($doctrine);
		var_dump($message);
        return $this->render('offer/index.html.twig', [
            'controller_name' => 'OfferController',
        ]);
    }
	#[Route('/create/offer', name: 'create_offer')]
	public function create_offer(Request $request, OfferRepository $offerRepository): Response
	{
		$newOffer = new Offer();
		// TODO Click on company presents to set the ID of the company
		$newOffer->setCompanyId(123);
		$newOffer->setStatus("Status of the offer");
		$newOffer->setDescription("Description of the offer");
		$now = date_create();
		$newOffer->setCreatedAt($now);

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
