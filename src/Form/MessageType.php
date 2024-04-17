<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Message;
use App\Entity\Tags;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
				'label' => 'Titre',
				'label_attr' => [
					'class' => 'form-label'
				],
				'attr' => [
					'placeholder' => 'Titre du message',
					'class' => 'form-control mb-2'
				]
			])
            ->add('message', TextareaType::class,
	            [
					'label' => 'Message',
		            'label_attr' => [
						'class' => 'form-label'
		            ],
		            'attr' => [
						'placeholder' => 'Contenu du message',
			            'class' => 'form-control mb-2'
		            ]
	            ]
            )
            ->add('tags', EntityType::class, [
                'class' => Tags::class,
                'choice_label' => 'libelle',
                'multiple' => true,
	            'label' => 'Tags',
	            'label_attr' => [
					'class' => 'form-label'
	            ],
	            'attr' => [
					'class' => 'form-control mb-2 d-flex flex-wrap'
	            ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
