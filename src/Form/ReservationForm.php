<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ReservationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
     $builder
         ->add('name', ChoiceType::class, [
             'choices' => [
                 "name1" => 1,
                 "name2" => 2,
                 "name3" => 3,
                 "name4" => 4
                 ]
             ])
         ->add('start', DateType::class, [
             'widget' => 'choice',
         ])
          ->add('end', DateType::class, [
             'widget' => 'choice',
         ])
         ->add('numberOfResidents', NumberType::class)
         ->add('submit', SubmitType::class);
    }

}