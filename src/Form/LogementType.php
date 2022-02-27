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
                'label' => false
            ])
            ->add('Adresse', TextType::class, [
                'required' => true,
                'label' => false
            ])
            ->add('Ville', TextType::class, [
                'required' => true,
                'label' => false
            ])
            ->add('CodePostal', NumberType::class, [
                'required' => true,
                'label' => false
            ])
            ->add('PersMax', NumberType::class, [
                'required' => true,
                'label' => false
            ])
            ->add('Description', TextareaType::class, [
                'required' => true,
                'label' => false
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
