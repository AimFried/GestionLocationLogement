<?php

namespace App\Form;

use App\Entity\LOGEMENT;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LogementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom')
            ->add('Adresse')
            ->add('Ville')
            ->add('CodePostal')
            ->add('PersMax')
            ->add('Description')
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
