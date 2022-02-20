<?php

namespace App\Form;

use App\Entity\News;
use App\Form\ApplicationType;
use Vich\UploaderBundle\Entity\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class NewsType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
            ->add('title', TextType::class,$this->getConfiguration(" titre"," tiiiii "))
            ->add('description', TextType::class,$this->getConfiguration(" description"," tiiiii "))
            ->add('fichier', FileType::class,
            ['required' => false,
            'label' => 'حمل الصور' ,
            'constraints' => [
              new File([
                  'maxSize' => '1024000',
                  'mimeTypes' => [
                      'image/pdf',
                  ],
                  'mimeTypesMessage' => 'Please upload a valid PDF document'
                  
              ])
              ]
           ]
       )
            ->add('photo', FileType::class, 
            ['required' => false,
              'label' => 'حمل الصور' ,
              'constraints' => [
                new File([
                    'maxSize' => '4000000',
                    'mimeTypes' => [
                        'image/jpeg',
                    ],
                    'mimeTypesMessage' => '(.jpg) حمل صورة صحيحة '
                ])
                ]
             ]
         )
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => News::class,
        ]);
    }
}
