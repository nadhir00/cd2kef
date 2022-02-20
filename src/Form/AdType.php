<?php

namespace App\Form;

use App\Entity\Ad;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdType extends AbstractType
{
    /**
     * permet davoir la onfguration de base d un champ
     * @param string $label
     * @param string $placeholder
     * @return array
     */

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('type', ChoiceType::class, [
            'choices' => [
                    
                    'تشكيات عامة' => [
                        'تشكيات عامة'=> 'تشكيات عامة' ,
                        'الانتصاب الفوضوي' =>'الانتصاب الفوضوي',
                        'الرخص'=> 'الرخص',
                        'الترقيم'=> 'الترقيم',
                        'الكلاب السائبة'=> 'الكلاب السائبة',

                    ],
                    'رفع الفضلات'=>'رفع الفضلات',
                    'الطرقات'=>'الطرقات',
                    'الانارة'=>'الانارة',
                    'الترصيف'=>'الترصيف',
                    'التطهير'=>'التطهير',
                    'تشكيات أخرى'=> 'تشكيات أخرى',

           
            ],'label'=>'نوع المشكل'
        ])
        ->add('lieu', ChoiceType::class, [
            'choices' => [
                    'نبر ' => 'نبر ',
                    'قصر ' => 'قصر ',
                    'ملاق ' => 'ملاق ',
                    'سيدي خيار' => 'سيدي خيار',
                    'تل الغزلان' => 'تل الغزلان',
                    'سركونة ' => 'سركونة ',
                    
            ],
            'label'=>'مكان المشكل '
        ])
        ->add('cite',TextareaType::class,['label' => 'الحي'])
     
         
            ->add('content',TextareaType::class,['label' => 'إشرح المشكل يإيجاز'])

            ->add('solution',TextareaType::class, ['label' => 'اقترح حلا للمشكل'])
           
            ->add('imagefile',FileType::class, 
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
         ->add('reponse',TextareaType::class, ['label' => ' الاجابة  '])   
        
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
