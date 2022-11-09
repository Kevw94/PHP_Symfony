<?php

namespace App\Controller;

use App\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Repository\CompanyRepository;
use Symfony\Component\HttpFoundation\Request;

class CompanyController extends AbstractController
{
    #[Route(
        '/company',
        name: 'app_company'
    )]
    public function index(CompanyRepository $compRepo): Response
    {
        $companies = $compRepo->findAll();

        return $this->render('company/index.html.twig', [
            'companies' => $companies,
            'controller_name' => 'CompanyController',
        ]);
    }

    #[Route(
        '/company/create',
        name: 'company_create',
    )]
    public function createCompany(CompanyRepository $compRepo, Request $request): Response
    {
        $company = new Company();

        $form = $this->createFormBuilder($company)
            ->add('name', TextType::class, ['label' => "Nom de l'entreprise"])
            ->add('email', TextType::class, ['label' => "Mail de l'entreprise"])
            ->add('save', SubmitType::class, ['label' => 'Créer une entreprise'])
            ->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $company = $form->getData();
            $compRepo->save($company, true);
            return $this->redirectToRoute('app_company');
        }


        return $this->renderForm('company/create.html.twig', [
            'form' => $form,
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
