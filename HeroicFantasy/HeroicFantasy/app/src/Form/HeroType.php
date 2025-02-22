<?php

namespace App\Form;

use App\Entity\Hero;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HeroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'required' => true
            ])
            ->add('class', ChoiceType::class, [
                'label' => 'Class',
                'choices' => [
                    'Druide' => 'Druide',
                    'Chaman' => 'Chaman',
                    'Guerrier' => 'Guerrier',
                    'Voleur' => 'Voleur',
                    'Mage' => 'Mage',
                ],
                'required' => true
            ])
            ->add('bio', TextareaType::class, [
                'label' => 'Bio',
                'required' => false
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Create'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hero::class,
        ]);
    }
}
