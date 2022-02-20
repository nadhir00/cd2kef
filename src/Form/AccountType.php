<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,['label' => 'اللقب'])
            ->add('prenom',TextType::class,['label' => 'الاسم'])
            ->add('date',BirthdayType::class, [
                'label' => 'تاريخ الولادة',
                'attr' => ['placeholder' => 'dd/mm/yyyy'],
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'input' => 'datetime',
                'html5' => false
                ])   
            ->add('genre',ChoiceType::class, [
                'choices' => [
                    'ذكر  ' => 'ذكر  ',
                    'أنثى  ' => 'أنثى  ',
                ],
               'label' => 'الجنس',
               'expanded'=> false ]) 
            ->add('tel',TelType::class,['label' => 'الهاتف'])
            ->add('email',TextType::class,['label' => ' البريد الالكتروني'])
           # ->add('picture')
           # ->add('hash')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
