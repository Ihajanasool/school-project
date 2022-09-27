<?php
/**
 * Julien Rajerison <julienrajerison5@gmail.com>.
 **/

namespace App\Form;

use App\Constant\EtudiantStatusConstant;
use App\Entity\User;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class StudentType.
 */
class PaymentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'type',
                ChoiceType::class,
                [

                    'label' => 'Type',
                    'required' => false,

                    'choices' => [
                        'Entrée' => 'Entrée',
                        'Sortie' => 'Sortie',
                    ],

                ]
            )

//            ->add(
//                'type',
//                TextType::class,
//                [
//                    'label' => 'Type'
//                ]
//            )
            ->add(
                'motif',
                TextType::class,
                [
                    'label' => 'Motif',
                ]
            )
            ->add(
                'montant',
                NumberType::class,
                [
                    'label' => 'Montant du payment',
                    'required' => false,
                ]
            )
            ->add(
                'User',
                EntityType::class,
                [
                    'class' => User::class,
                    'choice_label' => 'username',
                    'label' => 'Au nom de',
                    'query_builder' => function (EntityRepository  $er) {
                        return $er->createQueryBuilder('u')
                        ->where('u.roles LIKE \'["ROLE_ETUDIANT"]\'');
                    },
                    'required' => false,
                ]
            )
            ->add(
                'date_payment',
                DateTimeType::class,
                [
                    'label' => 'Date de paiement :',
                    'widget' => 'choice',
                    'html5' => false,
                    'attr' => [
                        'class' => 'datetimepicker',
                    ],
                    'format' => 'Y-m-d H:i',
                ]
            );
    }

}