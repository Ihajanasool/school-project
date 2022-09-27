<?php

namespace App\Form;

use App\Entity\PresenceEleve;
use App\Entity\Student;
use App\Entity\User;
use App\Repository\StudentRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class PresenceEleveType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'Present' => true,
                    'Absent' => false,
                ],
            ])
            ->add('User', EntityType::class, [
                'class'  => User::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.roles LIKE \'["ROLE_ETUDIANT"]\'')
                        ->andWhere('u.Session LIKE \'2021-2022\'');
                },
                'choice_label' => 'prenom',

            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PresenceEleve::class,
            
        ]);

       
    }
}
