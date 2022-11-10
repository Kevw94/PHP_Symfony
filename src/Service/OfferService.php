<?php
namespace App\Service;
use App\Entity\Offer;
use App\Entity\Company;
use App\Repository\OfferRepository;
use App\Repository\CompanyRepository;

class OfferService
{
    private OfferRepository $offerRepository;

    public function __construct(OfferRepository $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    public function findAllOffers(OfferRepository $offerRepository)
    {
        $offers = $offerRepository->findAll();
		return $offers;
    }

	public function findCompanyName(CompanyRepository $companyRepository, $offers) 
	{
		$offerArray = [];
		// var_dump($companyIds);
		foreach($offers as $value) {
			
			$companyName = $companyRepository->find($value->getCompanyId());
			
			// $offers[$value["companyName"]] = "bonjour";
			array_push($offerArray, $value, $companyName);
			print_r($offerArray);
			// var_dump($value);
			// exit;
		}
		// for ($i = 0; $i < count($companyIds); $i++) {
		// 	$companyId = $companyIds[$i]->getCompanyId();
		// 	$companyName = $companyRepository->find($companyId);
		// 	$offer = $companyName;
		// 	array_push($offerArray, $offer);
		// 	// $offer->{"description"} = $companyId->getDescription();
		// 	var_dump($offerArray);
		// };
		return; 
	}
	//faire une fonction pour prendre des offer en param et renvoyer leur parametre en description
	public function findPendingOffers()
	{
		$pendingOffers = $this->offerRepository->findOfferByStatus('applied');
		return $pendingOffers;
	}
}
