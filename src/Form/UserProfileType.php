<?php

namespace App\Form;

use App\Entity\UserProfile;
use App\Setting\Form\FormSetting;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $labelAttr = ['class' => FormSetting::LABEL_CLASS];
        $attr = ['class' => FormSetting::INPUT_CLASS];

//        $builder
//            ->add('name')
//            ->add('bio')
//            ->add('websiteUrl')
//            ->add('twitterUsername')
//            ->add('company')
//            ->add('location')
//            ->add(
//                'dateOfBirth',
//                DateType::class,
//                [
//                    'widget' => 'single_text',
//                    'required' => false
//                ]
//            );

        $builder
            ->add('name', TextType::class, [
                'label' => "名前",
                'label_attr' => $labelAttr,
                'attr' => $attr,
                'required' => false
            ])
            ->add('bio',TextType::class, [
                'label' => "プロフィール",
                'label_attr' => $labelAttr,
                'attr' => $attr,
                'required' => false
            ])
            ->add('websiteUrl',TextType::class, [
                'label' => "ウェブサイト",
                'label_attr' => $labelAttr,
                'attr' => $attr,
                'required' => false
            ])
            ->add('twitterUsername',TextType::class, [
                'label' => "X(Twitter)",
                'label_attr' => $labelAttr,
                'attr' => $attr,
                'required' => false
            ])
            ->add('company',TextType::class, [
                'label' => "所属会社",
                'label_attr' => $labelAttr,
                'attr' => $attr,
                'required' => false
            ])
            ->add('location',TextType::class, [
                'label' => "住んでいる地域",
                'label_attr' => $labelAttr,
                'attr' => $attr,
                'required' => false
            ])
            ->add('dateOfBirth', DateType::class, [
                'label' => "誕生日",
                'label_attr' => $labelAttr,
                'attr' => $attr,
                'widget' => 'single_text',
                'required' => false
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserProfile::class,
        ]);
    }
}
