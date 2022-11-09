<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;


class SkillController extends AbstractController
{
    #[Route('/skill/create', name: 'add_skill')]
    public function add_skill(SkillRepository $skillRepository, Request $request){

        $skill = new Skill();

        $form = $this->createFormBuilder($skill)

            ->add('skills',TextType::class, ['label' => "New skill"])
            ->add('save',SubmitType::class, ['label' => 'Save'])
            ->getForm();


        $form -> handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $skill = $form->getData();
            $skillRepository->save($skill, true);
            return $this->redirectToRoute('create_candidate');
        }

        return $this->renderForm('skill/create_skill.html.twig', [
            'form' => $form,
        ]);
    }
}