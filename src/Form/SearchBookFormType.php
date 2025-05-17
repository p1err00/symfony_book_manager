<?php


namespace App\Form;

use App\DTO\BookFilterDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SearchBookFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {

        $builder
            ->add("title", TextType::class, [
                "label" => "Titre",
                'attr' => ['class' => '', 'style' => 'margin-right: 5px'],
            ])
            ->add("author", TextType::class, [
                "label" => "Auteur",
                'required' => false,
                'attr' => ['class' => '', 'style' => 'margin-right: 5px'],
            ])
            ->add("category", ChoiceType::class, [
                "label" => "Categorie",
                'required' => false,
                'attr' => ['class' => '', 'style' => 'margin-right: 5px'],
                'choices' => [
                    '...' => '',
                    'Action' => 'action',
                    'Aventure' => 'aventure',
                    'Poesie' => 'poesie'
                ]
            ])
            ->add("publishedYear", IntegerType::class, [
                "label" => "Date de publication",
                'required' => false,
                'attr' => ['class' => '', 'style' => 'margin-right: 5px'],
            ])
            ->add("minPrice", IntegerType::class, [
                "label" => "Prix minimum",
                'required' => false,
                'attr' => ['class' => '', 'style' => 'margin-right: 5px'],
            ])
            ->add("maxPrice", IntegerType::class, [
                "label" => "Prix maximum",
                'required' => false,
                'attr' => ['class' => '', 'style' => 'margin-right: 5px'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => BookFilterDTO::class
        ]);
    }
}