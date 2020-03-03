<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options)   {
        $builder
            ->add('Title', TextType::class)
            ->add('Content', TextType::class)
            ->add('Autor', TextType::class)
            ->add('submit', SubmitType::class)
        ;
    }
    public function configureOptions(OptionsResolver $resolver)   {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
