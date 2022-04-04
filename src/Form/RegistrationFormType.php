<?php

namespace App\Form;

use App\Entity\User;
use DateTimeImmutable;
use Symfony\Component\Form\AbstractType;
use Doctrine\DBAL\Types\DateImmutableType;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    private $translator;
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'attr' => [
                    'placeholder' => 'Email',
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => "#^[a-zA-Z0-9.!$\#%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$#",
                        'message' => $this->translator->trans('The format of your email is incorrect')
                    ])
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => $this->translator->trans('new-password')],
                'constraints' => [
                    new NotBlank([
                        'message' => $this->translator->trans('Please enter a password'),
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => $this->translator->trans('Your password should be at least {{ limit }} characters'),
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Firstname',
                'attr' => [
                    'placeholder' => $this->translator->trans('Firstname'),
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => $this->translator->trans('Please enter a firstname'),
                    ]),
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Lastname',
                'attr' => [
                    'placeholder' => $this->translator->trans('Lastname'),
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => $this->translator->trans('Please enter a lastname'),
                    ]),
                ],
            ])
            ->add('address', TextType::class, [
                'label' => 'Address',
                'attr' => [
                    'placeholder' => $this->translator->trans('Address'),
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => $this->translator->trans('Please enter an address'),
                    ]),
                ],
            ])
            ->add('city', TextType::class, [
                'label' => $this->translator->trans('City'),
                'attr' => [
                    'placeholder' => 'City',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => $this->translator->trans('Please enter a city'),
                    ]),
                ],
            ])
            ->add('zipcode', TextType::class, [
                'label' => $this->translator->trans('Zipcode'),
                'attr' => [
                    'placeholder' => 'Zipcode',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => $this->translator->trans('Please enter a zipcode'),
                    ]),
                ],
            ])
            ->add('phone', TextType::class, [
                'label' => $this->translator->trans('Phone'),
                'attr' => [
                    'placeholder' => 'Phone',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => $this->translator->trans('Please enter a phone'),
                    ]),
                ],
            ])
            ->add('birthdate', DateTimeType::class, [
                'label' => $this->translator->trans('Birthdate'),
                'input' => 'datetime_immutable',
                'years' => range(date('Y') - 80, date('Y') + 5),
                'constraints' => [
                    new NotBlank([
                        'message' => $this->translator->trans('Please enter a birthdate'),
                    ]),
                ],
            ])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Male' => 'male',
                    'Female' => 'female',
                ],
                'multiple' => false,
                'expanded' => true

            ])

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => $this->translator->trans('You should agree to our terms.'),
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
