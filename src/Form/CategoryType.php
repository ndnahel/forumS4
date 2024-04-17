<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
				'label' => 'Nom',
				'label_attr' => [
					'class' => 'form-label'
				],
	            'attr' => [
	                'placeholder' => 'Nom de la catégorie',
		            'class' => 'form-control mb-2'
	            ]
            ])
            ->add('color', ColorType::class, [
				'label' => 'Couleur',
				'label_attr' => [
					'class' => 'form-label'
				],
	            'attr' => [
	                'class' => 'form-control'
	            ]
			])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
