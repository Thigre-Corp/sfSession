<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\Programme;
use App\Repository\ModuleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class ProgrammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var \App\Entity\Session | null $session */
        $session = ($options['session']);

        $builder
            ->add('nombreJour', IntegerType::class,[
                'constraints' => [
                    new NotBlank(),
                    new Positive,
                ],
                'attr' =>[
                    'min' =>'1',
                    'max' =>'99',
                    'value' => '1',
                ]
            ]
            )
            ->add('module', EntityType::class, [
                    'class' => Module::class,
                    'choice_label' => 'nom',
                    //filtre: modules non encore associés à cette session
                    'query_builder' => function (ModuleRepository $mr) use ($session) {
                        return $mr->createQueryBuilder('m')
                            ->andWhere('NOT EXISTS (
                                SELECT 1 FROM App\Entity\Programme p
                                WHERE p.module = m AND p.session = :session
                            )')
                            ->setParameter('session', $session)
                            ->orderBy('m.nom', 'ASC');
                    },
                    'placeholder' => 'Choisir un module…',
                ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success',
                    ]
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
        {
            $resolver->setDefaults([
                'data_class' => Programme::class,
                // Garde le CSRF activé si possible :
                'csrf_protection' => true,
            ]);
    
            // On déclare l’option custom "session"
            $resolver->setDefined('session');
            $resolver->setAllowedTypes('session', ['null', \App\Entity\Session::class]);
        }
}
