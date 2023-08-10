<?php

namespace App\Form;

use App\Entity\MicroPost;
use App\Setting\Form\FormSetting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MicroPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $labelAttr = ['class' => FormSetting::LABEL_CLASS];
        $attr = ['class' => FormSetting::INPUT_CLASS];

        $builder
            ->add('title', TextType::class, [
                'label' => "タイトル",
                'label_attr' => $labelAttr,
                'attr' => $attr
            ])
            ->add('text',TextareaType::class, [
                'label' => '内容',
                'label_attr' => $labelAttr,
                'attr' => $attr
            ])
            ->add('submit', SubmitType::class, [
                'label' => "投稿",
                'attr' => ['class' => FormSetting::SUBMIT_BUTTON_CLASS],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MicroPost::class,
        ]);
    }
}
