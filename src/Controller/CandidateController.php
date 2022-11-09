<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Repository\CandidateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CandidateController extends AbstractController
{
    #[Route('/candidate', name: 'app_candidate')]
    public function get_all_candidate(CandidateRepository $candidateRepository): Response
    {
        $candidates = $candidateRepository->findAll();
        //print_r($candidates);
        return $this->render('candidate/index.html.twig', [
            'controller_name' => 'CandidateController',
            'candidates' => $candidates
        ]);
    }

    #[Route('/candidate/new', name: 'create_candidate')]
    public function create_candidate(CandidateRepository $candidateRepository): Response
    {
        $candidate = new Candidate();
        $candidate->setName('Ezic');
        $candidate->setLastName('Remmour');
        $candidate->setEmail('ze!');
        $candidate->setStatus('en pleine campagne');

        $candidateRepository->save($candidate, true);

        return new Response('Created new candidate with id ' . $candidate->getId());
    }

    #[Route('/candidate/{id}/offers', name: 'find_candidate_candidacies')]
    public function get_user_offers(CandidateRepository $candidateRepository, int $id): Response
    {
        $candidate = $candidateRepository->find($id);
        //dd($candidacies);

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
}
