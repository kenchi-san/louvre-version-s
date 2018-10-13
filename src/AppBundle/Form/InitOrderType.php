<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InitOrderType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('createdAt')
            ->add('bookingDate', DateType::class, array(

                'widget' => 'single_text'
            ))
            ->add('qteOrder', \Symfony\Component\Form\Extension\Core\Type\IntegerType::class, ['attr' => ['min' => 0, 'max' => 10]])
            ->add('typeOrder', ChoiceType::class, array(
                'choices' => array(
                    'journée' => "full-day",
                    'demi-journée' => "half-day",

                ),
            ))
            //->add('price')
            //->add('bookingNumber')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Order'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_initorder';
    }


}
