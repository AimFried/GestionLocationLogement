<?php

namespace App\Form;

use App\Entity\Calendar;
use App\Entity\RESERVATION;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Entity\LOCATAIRE;
use App\Entity\LOGEMENT;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('DateDebut', DateType::class, [
                'required' => true,
                'label' => false
            ])
            ->add('DateFin', DateType::class, [
                'required' => true,
                'label' => false
            ])
            ->add('PrixNuit', MoneyType::class, [
                'required' => true,
                'label' => "Prix de la nuit"
            ])
            ->add('NbrAdulte', NumberType::class, [
                'required' => true,
                'label' => "Nombre(s) d'adulte(s)"
            ])
            ->add('NbrEnfant', NumberType::class, [
                'required' => true,
                'label' => "Nombre(s) d'enfant(s)"
            ])
            ->add('EtatContrat')
            ->add('TaxeVariable', MoneyType::class, [
                'required' => true,
                'label' => false
            
            ])
            ->add('Locataires', EntityType::class, array(
                'class' => LOCATAIRE::class,
                'choice_label' => 'Nom',
                'multiple' => false,
                'expanded' => false,
            ))
            ->add('Logements', EntityType::class, array(
                'class' => LOGEMENT::class,
                'choice_label' => 'Nom',
                'multiple' => false,
                'expanded' => false,
            ))
            ->add('CouleurFond', ColorType::class, [
                'required' => true,
                'label' => "Réservation",
                'mapped'  => false,
            ])
            ->add('CouleurBordure', ColorType::class, [
                'required' => true,
                'label' => "Bordure",
                'mapped'  => false,
            ])
            ->add('CouleurTexte', ColorType::class, [
                'required' => true,
                'label' => "Texte",
                'mapped'  => false,
            ])
            ->add('Description', TextareaType::class, [
                'required' => true,
                'label' => false,
                'mapped'  => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RESERVATION::class,
        ]);
    }
}
