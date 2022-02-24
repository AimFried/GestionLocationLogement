<?php

namespace App\Form;

use App\Entity\LOGEMENT;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class LogementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', TextType::class, [
                'required' => true,
                'label' => "Nom du logement"
            ])
            ->add('Adresse', TextType::class, [
                'required' => true,
                'label' => "L'adresse du logement"
            ])
            ->add('Ville', TextType::class, [
                'required' => true,
                'label' => "Ville du logement"
            ])
            ->add('CodePostal', NumberType::class, [
                'required' => true,
                'label' => "Code Postal du logement"
            ])
            ->add('PersMax', NumberType::class, [
                'required' => true,
                'label' => "Nombre(s) de personne(s) maximum"
            ])
            ->add('Description', TextareaType::class, [
                'required' => true,
                'label' => "Description du logement"
            ])
            ->add('Etat')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LOGEMENT::class,
        ]);
    }
}
