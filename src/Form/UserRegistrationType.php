<?php

namespace App\Form;

use App\Entity\UserOld;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('birthdate')
            ->add('avatar')
            ->add('mail')
            ->add('password')
            ->add('address')
            ->add('gender')
            ->add('accountStatus')
            ->add('createdAt')
            ->add('lastConnection')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserOld::class,
        ]);
    }
}
