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
             'choices' => $options['data']['flats']
             ])
         ->add('start', DateType::class, [
             'widget' => 'choice',
             'years' => $this->getYears(),
         ])
          ->add('end', DateType::class, [
             'widget' => 'choice',
              'years' => $this->getYears(),
         ])
         ->add('numberOfResidents', NumberType::class)
         ->add('submit', SubmitType::class);
    }

    private function getYears()
    {
        $thisYear = new \DateTime('now');
        return range($thisYear->format("Y"), $thisYear->format("Y")+4);
    }
}