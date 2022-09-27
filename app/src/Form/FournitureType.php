<?php

namespace App\Form;

use App\Entity\Fourniture;
use App\Entity\Room;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FournitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('number')
            ->add('date_insert')
            ->add(
                'room',
                EntityType::class,
                [
                    'class' => Room::class,
                    'choice_label' => 'name',
                    'label' => 'Au nom de',
                    'required' => false,
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fourniture::class,
        ]);
    }
}
