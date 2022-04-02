<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'label' => 'Lastname',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Firstname',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('birthdate', DateType::class, [
                'label' => 'Birthdate',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Gender',
                'choices' => [
                    'Maybe' => null,
                    'Yes' => true,
                    'No' => false,
                ],
                'expanded' => true,
                'multiple' => false,

            ])
            ->add('address', TextType::class, [
                'label' => 'Address',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('zipcode', TextType::class, [
                'label' => 'Zip Code',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'City',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('phone', TextType::class, [
                'label' => 'Phone number',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('Save changes', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-info mt-2 mb-3',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
