<?php

namespace App\Form;

use App\Entity\JobName;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', EntityType::class, [
                'attr' => [
                    'class' => 'banner-select'
                ],
                'required' => false,
                'placeholder' => 'Que recherchez-vous ?',
                'class' => JobName::class,
                'choice_label' => 'name',
                'choice_value' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('j')
                        ->orderBy('j.name', 'ASC');
                },
            ])
            ->add('region', TextType::class, [
                'required'   => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

        ]);
    }
}
