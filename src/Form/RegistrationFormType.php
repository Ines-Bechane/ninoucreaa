<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
            ->add('email')
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
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
            ->add('nom', TextType::class,[
                'label' => 'Nom',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Nom',
                    'class' => 'border border-primary'
                ]
            ])
            ->add('prenom', TextType::class,[
                'label' => 'Prenom',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prenom',
                    'class' => 'border border-primary'
                ]
            ])
            ->add('adresse', TextType::class,[
                'label' => 'Adresse',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Adresse',
                    'class' => 'border border-primary'
                ]
            ])
            ->add('ville', TextType::class,[
                'label' => 'ville',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ville',
                    'class' => 'border border-primary'
                ]
            ])
            ->add('cp', NumberType::class,[
                'label' => 'Cp',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Cp',
                    'class' => 'border border-primary'
                ]
            ])
            ->add('tel', TextType::class,[
                'label' => 'Telephone',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Numero telephone',
                    'class' => 'border border-primary'
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
