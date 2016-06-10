<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ImageForm extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('email', EmailType::class, array('attr' => array('placeholder' => 'Please Type Your Email Address')))
    ->add('file', FileType::class, array('attr' => array('class' => 'inputfile inputfile-5')))
    ->add('save', SubmitType::class, array('label' => 'Upload', 'attr' => array('class' => 'btn btn-primary')));
  }
  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
        'data_class' => 'AppBundle\Entity\Image',
    ));
  }
}
