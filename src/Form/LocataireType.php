<?php

namespace App\Form;

use App\Entity\LOCATAIRE;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class LocataireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', TextType::class, [
                'required' => true,
                'label' => false
            ])
            ->add('Prenom', TextType::class, [
                'required' => true,
                'label' => false
            ])
            ->add('Email' , TextType::class, [
                'required' => true,
                'label' => false
            ])
            ->add('Telephone', TextType::class, [
                'required' => true,
                'label' => false
            ])
            ->add('Adresse' , TextType::class, [
                'required' => true,
                'label' => false
            ])
            ->add('CodePostal' , NumberType::class, [
                'required' => true,
                'label' => false
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LOCATAIRE::class,
        ]);
    }
}
