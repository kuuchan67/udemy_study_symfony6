<?php

namespace App\Form;

use App\Entity\User;
use App\Setting\Form\FormSetting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
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

        $labelAttr = ['class' => FormSetting::LABEL_CLASS];
        $attr = ['class' => FormSetting::INPUT_CLASS];
        $checkAttr = ['class' => FormSetting::CHECKBOX_CLASS];
        $checkLabelAttr =  ['class' => FormSetting::CHECKBOX_LABEL_CLASS];

        $builder
            ->add('email', TextType::class, [
                'label' => "メールアドレス",
                'label_attr' => $labelAttr,
                'attr' => $attr,
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => "同意",
                'label_attr' => $checkLabelAttr,
                'attr' => $checkAttr,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,

                'mapped' => false,
                'label' => "パスワード",
                'label_attr' => $labelAttr,
                'invalid_message' => 'パスワードの確認と合っていません',
                'attr' => ['autocomplete' => 'new-password', 'class' => FormSetting::INPUT_CLASS],
                'first_options' => [
                    'label' => 'パスワード',
                    'mapped' => false,
                    'attr' => ['class' => FormSetting::INPUT_CLASS],
                ],
                'second_options' => [
                    'label' => 'パスワードの確認',
                    'label_attr' => $labelAttr,
                    'mapped' => false,
                    'attr' => ['class' => FormSetting::INPUT_CLASS],
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => '入力してください',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => '最低 {{ limit }} 文字以上で入力してください',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('userProfile', UserProfileType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
