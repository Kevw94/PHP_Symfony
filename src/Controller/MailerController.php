<?php

namespace App\Controller;

use App\Repository\CandidateRepository;
use App\Repository\CompanyRepository;
use App\Repository\OfferRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerController extends AbstractController
{
    #[Route('/mailer/{id}/{idUser}/{companyId}', name: 'app_mailer')]
    public function sendEmail(MailerInterface $mailer, int $id, int $idUser, int $companyId, CompanyRepository $compRepo, CandidateRepository $candidateRepo, OfferRepository $offerRepo): Response
    {
        $company = $compRepo->find($companyId);
        $companyName = $company->getName();
        $companyEmail = $company->getEmail();

        $candidate = $candidateRepo->find($idUser);
        $candidateName = $candidate->getName();
        $candidateLastName = $candidate->getLastName();
        $candidateEmail = $candidate->getEmail();

        $offer = $offerRepo->find($id);
        $offerDescription = $offer->getDescription();


        $email = (new TemplatedEmail())
            ->from(new Address($companyEmail, $companyName))

            ->to($candidateEmail)
            ->htmlTemplate('email/accepted.html.twig')
            ->subject('Nous vous avons choisi !')

            // pass variables (name => value) to the template
            ->context([
                'candidateName' => $candidateName,
                'candidateLastName' => $candidateLastName,
                'offerDescription' => $offerDescription,
                'companyName' => $companyName
            ]);

        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            var_dump($e);
        }

        return $this->render('mailer/index.html.twig', [
            'controller_name' => 'MailerController',
        ]);
    }
}

