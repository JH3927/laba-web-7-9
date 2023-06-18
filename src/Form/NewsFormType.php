<?php

namespace App\Form;

use App\Entity\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\NotBlank;

class NewsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {   
    $builder
        ->add('name', TextType::class, [
            'required' => true,
            'constraints' => [new Length(['min' => 3, 'minMessage' => 'Название новости должно быть минимум {{ limit }} символов']),
                new NotBlank(['message' => 'Пожалуйста введите название новости']),],
        ])
        ->add('description', TextareaType::class, [
            'required' => true,
            'constraints' => [new Length(['min' => 8, 'minMessage' => 'Описание новости должно быть минимум {{ limit }} символов']),
                new NotBlank(['message' => 'Пожалуйста описание новости'])],
        ])
        ->add('content', TextareaType::class, [
            'required' => true,
            'constraints' => [new Length(['min' => 15, 'minMessage' => 'Содержание новости должно быть минимум {{ limit }} символов']),
                new NotBlank(['message' => 'Пожалуйста текст новости'])],
        ])
        ->add('fotopath', FileType::class, [
                'label' => 'Brochure (PDF file)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '6144k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/svg',
                        ],
                        'mimeTypesMessage' => 'Пожалуйста загрузите фото с расширениями img/png/svg',
                    ]),
                    new NotBlank(['message' => 'Пожалуйста загрузите фото новости']),
                ],

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => News::class,
        ]);
    }
}
