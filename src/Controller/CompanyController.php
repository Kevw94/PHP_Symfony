<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
<<<<<<< HEAD
use Doctrine\Persistence\ManagerRegistry;

class CompanyController extends AbstractController 
{
 #[Route(
    '/company',
    name: 'company_create'
 )]
 public function createCompany(RegistryManager $doctrine,string $name, string $email):Response
 {
    $entityManager = $doctrine->getManager();

    $company = new Company();

    $company->setName($name);
    $company->setMail($email);

    $entityManager->persist($company);

    $entityManager->flush();

    return new Response('Successfully created new company');
 }
}
=======

class CompanyController extends AbstractController
{
    #[Route('/company', name: 'app_company')]
    public function index(): Response
    {
        return $this->render('company/index.html.twig', [
            'controller_name' => 'CompanyController',
        ]);
    }
}
>>>>>>> main
