<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\Session;
use App\Entity\Programme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProgrammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       // dd($options['data']);
      // $arrayModules = $options['data'];

        $builder
            ->add('nombreJour', )
          /*  ->add('session', EntityType::class, [ ///// pas nécessaire -> l'id de la session est transmis malgré tout...
                'class' => Session::class,
                'choice_label' => 'id',
                //'type' => 'hidden'
            ])*/
            ->add('module', EntityType::class, [
                'class' => Module::class,
                //'choices' => $arrayModules,
                'choice_label' => 'nom',
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
            'data_class' => Programme::class, // 
            'csrf_protection' => false,             //------------------------------------------problématique.... POURQUOI ?
        ]);
    }
}
