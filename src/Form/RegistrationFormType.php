<?php

namespace App\Form;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\DBAL\Types\DateImmutableType;
use Symfony\Component\Form\AbstractType;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Email',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter an email',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Firstname',
                'attr' => [
                    'placeholder' => 'Firstname',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a firstname',
                    ]),
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Lastname',
                'attr' => [
                    'placeholder' => 'Lastname',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a lastname',
                    ]),
                ],
            ])
            ->add('address', TextType::class, [
                'label' => 'Address',
                'attr' => [
                    'placeholder' => 'Address',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter an address',
                    ]),
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'City',
                'attr' => [
                    'placeholder' => 'City',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a city',
                    ]),
                ],
            ])
            ->add('zipcode', TextType::class, [
                'label' => 'Zipcode',
                'attr' => [
                    'placeholder' => 'Zipcode',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a zipcode',
                    ]),
                ],
            ])
            ->add('phone', TextType::class, [
                'label' => 'Phone',
                'attr' => [
                    'placeholder' => 'Phone',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a phone',
                    ]),
                ],
            ])
            ->add('birthdate', DateTimeType::class, [
                'label' => 'Birthdate',
                'input' => 'datetime_immutable',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a birthdate',
                    ]),
                ],
            ])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'male' => 'male',
                    'female' => 'female',
                ],
                'multiple' => false,
                'expanded' => true

            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
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
