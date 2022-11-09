<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Form\Type\CandidateType;
use App\Repository\CandidateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CandidateController extends AbstractController
{
    const OPEN = "open";
    const CLOSE = "close";

    #[Route('/candidate', name: 'app_candidate')]
    public function get_all_candidate(CandidateRepository $candidateRepository): Response
    {
        $candidates = $candidateRepository->findAll();

        return $this->render('candidate/index.html.twig', [
            'controller_name' => 'CandidateController',
            'candidates' => $candidates
        ]);
    }

    #[Route('/candidate/create', name: 'create_candidate', methods: ['GET', 'POST'])]
    public function create_candidate(Request $request, CandidateRepository $candidateRepository): Response
    {
        $newCandidate = new Candidate();
        $newCandidate->setStatus(self::OPEN);

        $form = $this->createForm(CandidateType::class, $newCandidate);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newCandidate = $form->getData();
            $candidateRepository->save($newCandidate, true);
            return $this->redirectToRoute('app_candidate');
        }

        return $this->renderForm('candidate/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/candidate/{id}/offers', name: 'find_candidate_candidacies')]
    public function get_user_offers(CandidateRepository $candidateRepository, int $id): Response
    {
        $candidate = $candidateRepository->find($id);

        if (!$candidate) {
            return new Response('Error no user found for id: ' . $id);
        }
        $candidacies = $candidate->getCandidacies();
        //dd($offers);
        return $this->render('candidate/myoffers.html.twig', [
            'controller_name' => 'CandidateController',
            'candidacies' => $candidacies
        ]);
    }

    #[Route(
        '/candidate/edit/{id}',
        name: 'candidate_edit',
    )]
    public function editCandidate(CandidateRepository $candidateRepository, Request $request, int $id): Response
    {
        $candidateToEdit = $candidateRepository->find($id);

        $form = $this->createForm(CandidateType::class, $candidateToEdit);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $candidateToEdit = $form->getData();
            $candidateRepository->save($candidateToEdit, true);
            return $this->redirectToRoute('app_candidate');
        }

        return $this->renderForm('candidate/edit.html.twig', [
            'form' => $form,
        ]);
    }
}
