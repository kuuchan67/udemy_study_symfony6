<?php

namespace App\Form;

use App\Entity\MicroPost;
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
        $labelAttr = ['class' => 'block text-sm text-gray-700 dark:text-gray-300 font-medium'];
        $attr = ['class' => 'block w-full shadow-sm border-gray-300 dark:border-transparent dark:text-gray-800 rounded-md border p-2 mt-1 mb-2'];

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
                'attr' => ['class' => 'block w-full shadow-sm border-transparent bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-400 text-white rounded-md border p-2 mt-4 mb-2'],
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
