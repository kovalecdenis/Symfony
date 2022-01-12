<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PostForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Name', TextType::class, [
            'translation_domain' => 'post',
        ]);
        $builder->add('Description', TextareaType::class, [
            'translation_domain' => 'post',
        ]);
        $builder->add('Published_at', DateType::class, [
           'widget' => 'single_text',
            'translation_domain' => 'post',
        ]);
        $builder->add('Submit', SubmitType::class, [
           'attr' => [
               'style' => 'margin-top: 15px',
           ],
            'translation_domain' => 'post',
        ]);
    }
}
