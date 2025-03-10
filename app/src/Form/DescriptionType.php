<?php

namespace App\Form;


use phpDocumentor\Reflection\DocBlock\Description;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;



class DescriptionType extends AbstractType
    {
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    $builder
                ->add('label', TextType::class)
                ->add('price', IntegerType::class)
                ;
    }
//
//    public function configureOptions(OptionsResolver $resolver): void
//    {
//    $resolver->setDefaults([
//    'data_class' => Description::class,
//    ]);
//    }
    }

?>