<?php

namespace App\Form;

use App\Entity\RESERVATION;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\LOCATAIRE;
use App\Entity\LOGEMENT;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('DateDebut')
            ->add('DateFin')
            ->add('PrixNuit')
            ->add('PrixTotal')
            ->add('NbrAdulte')
            ->add('NbrEnfant')
            ->add('EtatContrat')
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RESERVATION::class,
        ]);
    }
}
