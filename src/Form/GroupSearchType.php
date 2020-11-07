<?php

namespace App\Form;


use App\Entity\GroupSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('filterGroup',  ChoiceType::class, [
                'choices'  => [
                    'Afficher mes permanences' => false,
                    'Afficher les groupes' => true,
                ],
                'label' => 'Filtrer',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GroupSearch::class,
            'method' => 'post',
            'csrf_protection' => false,
        ]);
    }
}
