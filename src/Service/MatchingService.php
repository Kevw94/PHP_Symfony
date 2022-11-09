<?php

namespace App\Service;

use App\Entity\Candidate;
use App\Entity\Skill;
use App\Repository\CandidateRepository;
use App\Repository\OfferRepository;
use App\Repository\SkillRepository;

class MatchingService
{

    private CandidateRepository $candidateRepository;
    private OfferRepository $offerRepository;

    public function __construct(CandidateRepository $candidateRepository,
                                OfferRepository     $offerRepository,)
    {
        $this->candidateRepository = $candidateRepository;
        $this->offerRepository = $offerRepository;
    }

    public function matchOffers(Candidate $candidate): array
    {
        $result = array();
//        $candidate = $this->candidateRepository->find($id);
        $candidate_skills = $candidate->getSkills();
        $skill_offers = array();

        foreach ($candidate_skills as $skill_data) {
            $tab_temp = $skill_data->getOffers();
            foreach ($tab_temp as $offer) {
                $skill_offers[] = $offer;
            }
        }
        $all_offers = $this->offerRepository->findAll();

        foreach ($all_offers as $offer) {
            foreach ($skill_offers as $filtered_offer) {
                if ($filtered_offer['id'] == $offer['id']) {
                    if (!in_array($filtered_offer, $result)) {
                        $result[] = $filtered_offer;
                    }
                }
            }
        }

        return $result;
    }
}