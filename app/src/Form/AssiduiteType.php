<?php

namespace App\Form;

use App\Entity\Assiduite;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\UserRepository;
use function Symfony\Component\String\u;

class AssiduiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
//        $profs = UserRepository::class->findByRoles('ROLE_PROFS', 'Esti');
        $builder
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Absent' => 'Absent',
                    'Present' => 'Present',
                ]
            ])
            ->add('motif')
            
            ->add('user', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (EntityRepository  $er) {
                    return $er->createQueryBuilder('u')
                    ->where('u.roles LIKE \'["ROLE_PROFS"]\'');
                },
                'choice_label' => 'username',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Assiduite::class,
        ]);
    }
}
