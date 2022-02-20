<?php

namespace App\Form;

use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PasswordUpdateType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('oldPassword', PasswordType::class, $this->getConfiguration("كلمة السر القديمة", " الرجاء إدخال كلمة السر القديمة"))
        ->add('newPassword', PasswordType::class, $this->getConfiguration("كلمة السر الجديدة", " الرجاء إدخال كلمة السر الجديدة "))
        ->add('confirmPassword', PasswordType::class, $this->getConfiguration("تأكد كلمة السر الجديدة ", " الرجاء تأكد  إدخال كلمة السر الجديدة ")) ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
