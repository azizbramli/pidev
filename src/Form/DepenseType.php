<?php

namespace App\Form;

use App\Entity\Depense;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Categorie;


class DepenseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prix', null, array('label' => false), NumberType::class, [
                'scale' => 2, ])
            //->add('date', null, array('label' => false), DateType::class)
            ->add('etat', null, array('label' => false),TextType::class)
            ->add('description', null, array('label' => false),TextType::class)
            ->add('totalParMois', null, array('label' => false), NumberType::class, [
                'scale' => 2, ])
                ->add('categories', EntityType::class, [
                    'class' => Categorie::class,
                    'choice_label' => 'nom',
                    'multiple' => true,
                    'expanded' => false,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Depense::class,
        ]);
    }
}