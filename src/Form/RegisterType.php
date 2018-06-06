<?php 
namespace App\Form;
use App\Entity\Register;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

class RegisterType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->setAction('register')
		->setMethod('POST')
		->add('name', TextType::class, [
		'required' => true,
		'label' => false,
		'attr' => ['class' => 'span8', 'style' => 'width:400px;', 'placeholder' => 'Display name']])
		->add('username', TextType::class, [
		'required' => true,
		'label' => false,
		'attr' => ['class' => 'span8', 'style' => 'width:400px;', 'placeholder' => 'Username']])
		->add('pass', PasswordType::class, [
		'required' => true,
		'label' => false,
		'attr' => ['class' => 'span8', 'style' => 'width:400px;', 'placeholder' => 'Password']])
		->add('confirmpass', PasswordType::class, [
		'required' => true,
		'label' => false,
		'attr' => ['class' => 'span8', 'style' => 'width:400px;', 'placeholder' => 'Confirm password']])
		->add('mail', EmailType::class, [
		'required' => true,
		'label' => false,
		'attr' => ['class' => 'span8', 'style' => 'width:400px;', 'placeholder' => 'example@example.com']])
		->add('confirmmail', EmailType::class, [
		'required' => true,
		'label' => false,
		'attr' => ['class' => 'span8', 'style' => 'width:400px;', 'placeholder' => 'Confirm Email address']])
		->add('pincode', TextType::class, [
		'required' => true,
		'label' =>false,
		'attr' => ['class' => 'span8', 'style' => 'width:400px;', 'placeholder' => '5 Digit numbers', 'maxlength' => 5]])
		->add('country', TextType::class, [
		'required' => true,
		'label' => false,
		'attr' => ['class' => 'span8', 'style' => 'width:400px;', 'placeholder' => 'Your Country']])
		->add('address', TextType::class, [
		'required' => true,
		'label' => false,
		'attr' => ['class' => 'span8', 'style' => 'width:400px;', 'placeholder' => 'Your address']])
		->add('submit', SubmitType::class, [
		'label' => 'Register',
		'attr' => ['class' => 'btn btn-primary btn-green', 'style'=>'height:28px;', 'value' => 'Submit']]);
	}

   public function configureOption(OptionsResolver $resolver)
   {
     $resolver->setDefaults(['data_class' => Register::class]);
   }
}   