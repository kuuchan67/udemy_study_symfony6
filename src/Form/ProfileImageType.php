<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProfileImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $labelAttr = ['class' => 'shadow-sm border-transparent bg-gray-300 hover:bg-gray-400 dark:bg-gray-700 dark:hover:bg-gray-900 cursor-pointer rounded-md border p-2'];
        $attr = ['class' => "hidden"];
        $builder
            ->add('profileImage', FileType::class,[
                'label' => "画像変更",
                'label_attr' => $labelAttr,
                'attr' => $attr,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpag',
                            'image/png'
                        ],
                        "mimeTypesMessage"=> "PNGまたはJPG画像ファイルをアップロードしてください"
                    ])
                ]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
