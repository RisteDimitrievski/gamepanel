<?php 
namespace App\Form;

use App\Entity\Login;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

class LoginType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->setAction('login')
		->setMethod('POST')
		->add('email', EmailType::class, [
		'label' => false,
		'attr' => ['autofocus' => false, 'class' => 'input-block-level', 'placeholder' => 'example@example.com', 'required' => true]])
		->add('password', PasswordType::class, [
		'label' => false,
		'attr' => ['autofocus' => false, 'class' => 'input-block-level', 'placeholder' => 'Your account password', 'required' => true]])
		->add('submit', SubmitType::class, [
		'block_name' => 'Login',
		'label' => 'Login',
		'attr' => ['class' => 'btn btn-envato btn-block btn-large', 'style' => 'height:28px;']]);
	}
	
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(['data_class' => Login::class]);
	}
}
