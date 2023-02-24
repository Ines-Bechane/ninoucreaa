<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class, [
            "label" => "Email :",
            'row_attr' => [
                'class' => 'form-floating',
            ],
            "required" => false,
            "attr" => [ // tableau des attributs 
                "class" => "border border-dark row mb-3"

            ]
        ])
            ->add('RGPDConsent', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
                'label' => "En m'inscrivant à ce site j'accepte les conditions général"
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => 'password',
                'row_attr' => [
                    'class' => 'form-floating',
                ],
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password','class' => 'border border-black row mb-3'],
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
            ->add('nom', TextType::class,[
                'label' => 'Nom',
                'row_attr' => [
                    'class' => 'form-floating',
                ],
                'required' => false,
                'attr' => [
                    'placeholder' => 'Nom',
                    'class' => 'border border-dark row mb-3'
                ]
            ])
            ->add('prenom', TextType::class,[
                'label' => 'Prenom',
                'row_attr' => [
                    'class' => 'form-floating',
                ],
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prenom',
                    'class' => 'border border-dark row mb-3'
                ]
            ])
            ->add('adresse', TextType::class,[
                'label' => 'Adresse',
                'row_attr' => [
                    'class' => 'form-floating',
                ],
                'required' => false,
                'attr' => [
                    'placeholder' => 'Adresse',
                    'class' => 'border border-dark row mb-3'
                ]
            ])
            ->add('ville', TextType::class,[
                'label' => 'ville',
                'row_attr' => [
                    'class' => 'form-floating',
                ],
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ville',
                    'class' => 'border border-dark row mb-3'
                ]
            ])
            ->add('cp', NumberType::class,[
                'label' => 'Cp',
                'row_attr' => [
                    'class' => 'form-floating',
                ],
                'required' => false,
                'attr' => [
                    'placeholder' => 'Cp',
                    'class' => 'border border-dark row mb-3'
                ]
            ])
            ->add('tel', TextType::class,[
                'label' => 'Telephone',
                'row_attr' => [
                    'class' => 'form-floating',
                ],
                'required' => false,
                'attr' => [
                    'placeholder' => 'Numero telephone',
                    'class' => 'border border-dark row mb-3'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
