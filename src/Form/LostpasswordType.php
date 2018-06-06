<?php 
namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\LostPassword;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

class LostpasswordType extends AbstractType
{
	public function builder(FormBuilderInterface $builder, array $options)
	{
		$builder
		->setAction('recover')
		->setMethod('POST')
		->add('email', EmailType::class, [
		'label'    => 'Email Address',
		'attr'     => ['autofocus' => false, 'class' => 'span8', 'placeholder' => 'example@example.com' ]])
		->add('submit', SubmitType::class, [
		'label' => 'Reset Password',
		'attr' => ['class' => 'btn btn-primary btn-green']]);
	}
	
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(['data_class' => LostPassword::class]);
	}
	
}