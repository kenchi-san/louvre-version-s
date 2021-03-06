<?php

namespace AppBundle\Form;

use AppBundle\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
            ->add('bookingDate', DateType::class, array(

                'widget' => 'single_text'

            ))
            ->add('qteOrder', IntegerType::class, ['attr' => ['min' => 1, 'max' => 1000]])
            ->add('typeOrder', ChoiceType::class, [
                'choices' => [
                    Order::TYPE_FULL_DAY => "jour plein",
                    Order::TYPE_HALF_DAY => "demi-journée",

                ],
            ])
            ->add('mail', EmailType::class, [
                'label' => 'e-mail'
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Order::class
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
