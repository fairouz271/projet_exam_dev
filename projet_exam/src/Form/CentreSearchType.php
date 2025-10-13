<?php

namespace App\Form;

use App\Entity\Activity;
use App\Entity\Adress;
use App\Entity\Center;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class CentreSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('query', TextType::class, [
            'required' => false,
            'label' => 'Rechercher par nom ou adresse du Centre',
            'attr' => ['placeholder' => 'Tapez le nom ou l’adresse...']
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
