<?php

namespace App\Form;

use App\Entity\Application;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('email', EmailType::class)
            ->add('phone', TextType::class)
            ->add('cv', FileType::class, [
                'mapped' => false,
                'required'=> false,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/msword',
                            'image/png',
                            'image/jpeg'
                        ],
                    ])
                ],
            ])
            ->add('vitalCard', FileType::class, [
                'mapped' => false,
                'required'=> false,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/msword',
                            'image/png',
                            'image/jpeg'
                        ],
                    ])
                ],
            ])
            ->add('idCard', FileType::class, [
                'mapped' => false,
                'required'=> false,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/msword',
                            'image/png',
                            'image/jpeg'
                        ],
                    ])
                ],
            ])
            ->add('medicalVisit', FileType::class, [
                'mapped' => false,
                'required'=> false,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/msword',
                            'image/png',
                            'image/jpeg'
                        ],
                    ])
                ],
            ])
            ->add('licenses', FileType::class, [
                'mapped' => false,
                'required'=> false,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/msword',
                            'image/png',
                            'image/jpeg'
                        ],
                    ])
                ],
            ])
            ->add('clearances', FileType::class, [
                'mapped' => false,
                'required'=> false,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/msword',
                            'image/png',
                            'image/jpeg'
                        ],
                    ])
                ],
            ])
            ->add('securityFormation', FileType::class, [
                'mapped' => false,
                'required'=> false,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/msword',
                            'image/png',
                            'image/jpeg'
                        ],
                    ])
                ],
            ])
            ->add('homeJustification', FileType::class, [
                'mapped' => false,
                'required'=> false,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/msword',
                            'image/png',
                            'image/jpeg'
                        ],
                    ])
                ],
            ])
            ->add('rib', FileType::class, [
                'mapped' => false,
                'required'=> false,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/msword',
                            'image/png',
                            'image/jpeg'
                        ],
                    ])
                ],
            ])
            ->add('drivingLicense', FileType::class, [
                'mapped' => false,
                'required'=> false,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/msword',
                            'image/png',
                            'image/jpeg'
                        ],
                    ])
                ],
            ])
            ->add('grayCard', FileType::class, [
                'mapped' => false,
                'required'=> false,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/msword',
                            'image/png',
                            'image/jpeg'
                        ],
                    ])
                ],
            ])
            ->add('message', TextareaType::class, [
                'required'=> false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }
}
