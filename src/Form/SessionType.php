<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Formation;
use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('dateDebut')
            ->add('dateFin')
            ->add('nombrePlacesTotales')
            ->add('nombrePlacesReservees')
           /* ->add('stagiaires', EntityType::class, [
                'class' => Stagiaire::class,
                'choice_label' => 'id',
                'multiple' => true,
            ]) */
            ->add('formation', EntityType::class, [
                'class' => Formation::class,
                'choice_label' => 'nom',
            ])
            ->add('Valider', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
