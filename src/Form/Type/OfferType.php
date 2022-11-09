<?php

// src/Form/Type/OfferType.php
namespace App\Form\Type;

use App\Entity\Company;
use App\Entity\Skill;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Offer;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('company', EntityType::class, [
                'class' => Company::class,
                'label' => "Nom de votre entreprise",
                'choice_label' => 'name'])
//            ->add('status', TextType::class)
            ->add('skills', EntityType::class, [
                'class' => Skill::class,
                'label' => "Compétences recherchées",
                'choice_label' => 'skills',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('description', TextType::class)
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}