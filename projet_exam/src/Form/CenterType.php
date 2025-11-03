<?php

namespace App\Form;

use App\Entity\Activity;
use App\Entity\Center;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CenterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom'])
            ->add('phoneNumber', TextType::class, ['label' => 'Téléphone'])
            ->add('schedules', TextareaType::class, ['label' => 'Horaires'])
            ->add('adress', AdressType::class, [
                'label' => false,
            ])
                    ->add('price', IntegerType::class, ['label' => 'Prix', 'required' => false])
            ->add('description', TextareaType::class, ['label' => 'Description', 'required' => false])
            ->add('imagePath', FileType::class, [
                'label' => 'Image principale',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader une image valide (jpeg ou png)',
                    ])
                ],
            ])

            ->add('activities', EntityType::class, [
                'class' => Activity::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Activités',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Center::class,
        ]);
    }
}
