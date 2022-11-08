<?php
namespace App\Service;
use App\Entity\Offer;
use Doctrine\Persistence\ManagerRegistry;

class OfferService
{    
    public function TryFindAllOffers(ManagerRegistry $doctrine)
    {
        $product = $doctrine->getRepository(Offer::class)->findAll();
		return $product;
    }
}
