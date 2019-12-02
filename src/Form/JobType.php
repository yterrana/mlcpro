<?php

namespace App\Form;

use App\Entity\Job;
use App\Entity\JobName;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', EntityType::class, [
                'class' => JobName::class,
                'choice_label' => 'name',
                'choice_value' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('j')
                        ->orderBy('j.name', 'ASC');
                },
            ])
            ->add('city', TextType::class)
            ->add('region', TextType::class)
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'CDI' => 'CDI',
                    'Intérim' => 'Intérim',
                ],
            ])
            ->add('description', TextareaType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Job::class,
        ]);
    }
}
