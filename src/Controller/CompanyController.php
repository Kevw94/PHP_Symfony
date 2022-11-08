<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class CompanyController extends AbstractController 
{


#[Route(
    '/company', 
    name: 'app_company'
)]
public function index(): Response
{
    return $this->render('company/index.html.twig', [
        'controller_name' => 'CompanyController',
    ]);
}

 #[Route(
    '/company/create',
    name: 'company_create'
 )]
 public function createCompany():Response
 {
    return $this->render('company/create.html.twig', [
        'controller_name' => 'CompanyController',
    ]);
 }

}
//  {
//     // string $name, string $email
//     $entityManager = $doctrine->getManager();

//     $company = new Company();

//     $company->setName('gulag');
//     $company->setMail('gulag@gmail.com');

//     $entityManager->persist($company);

//     $entityManager->flush();

//     return new Response('Successfully created new company');
//  }
// }
