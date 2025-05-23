<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {

        $builder
            ->add("email", EmailType::class, [
                'label' => 'Email', 'attr' => ['class' => 'form-control', 'style' => 'margin-right: 5px'],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password',
                'attr' => ['class'=> 'form-control', 'style'=> 'Margin-right: 5px'],
            ])
            ->add('save', SubmitType::class, ['label' => 'Login'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_csrf_token',
            'csrf_token_id'=> 'authenticate',
        ]);
    }
}