<?php

namespace App\Controller;
use App\Entity\Login;
use App\Form\LoginType;
use App\Repository\LoginRepository;

use App\Entity\Register;
use App\Form\RegisterType;
use App\Repository\RegisterRepository;

use App\Repository\FunctionsRepository;

use App\Entity\Lostpassword;
use App\Form\LostpasswordType;
use App\Repository\LostpasswordRepository;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\FormFactory;





class GlobalController extends Controller
{
    /**
     * @Route("/global", name="global")
     */
    public function index(Request $request, FunctionsRepository $function, LoginRepository $repository, Session $session)
    {
		if(!$repository->loggedIn($session->get('cmssessionid')))
		{
			return $this->redirectToRoute('login');
		}
        return $this->render('global/index.html.twig', [
            'controller_name' => 'GlobalController',
        ]);
    }
	
	public function login(Request $request, FunctionsRepository $function, LoginRepository $repository, Session $session)
	{
		$cookie = $request->cookies;
		/*
		if($request->hasPreviousSession('cmssessionid') && $cookie->has('username'))
		{
			return $this->redirectToRoute('index');
		}
		*/
		$response = new Response();
		$login = new Login();
		$register = new Register();
		$formLogin = $this->createForm(LoginType::class, $login, array('csrf_protection' => false));
		$formRegister = $this->createForm(RegisterType::class, $register, array('csrf_protection' => false));
		$formLogin->handleRequest($request);
		
		$page = array('title' => 'Game CP');
		if($formLogin->isSubmitted() && $formLogin->isValid())
		{
			$login = $formLogin->getData();
			$post = array(
			'email' => $function->_clean_input($login->getEmail()),
			'password' => $function->_clean_input($login->getPassword()));
			if(empty($post['email'] or $post['password']))
			{
				$this->addFlash('message', 'You cannon login with empty email or password');
				return $this->redirectToRoute('login');
			}
			if($repository->queryLogin($post['email'], $post['password']))
			{
				return $this->redirectToRoute('index');
			} else {
				$this->addFlash('message', "Invalid Email Address or password specified. Click <a href='/forgotpw'>Here</a> to request new password.");
				return $this->redirectToRoute('login');
			}
		}
			
		
		
		return $this->render('global/login.html.twig', array('websiteName' => $page['title'], 'formLogin' => $formLogin->createView(), 'formRegister' => $formRegister->createView()));
	}


public function register(Request $request, LoginRepository $login, RegisterRepository $repository, FunctionsRepository $function, Session $session)
{
	
	if($login->loggedIn('cmssessionid'))
	{
		return $this->redirectToRoute('/');
	}
	$register = new Register();
	$formRegister = $this->createForm(RegisterType::class, $register, array('csrf_protection' => false));
	$formRegister->handleRequest($request);
	if($formRegister->isSubmitted() && $formRegister->isValid())
	{
		$register = $formRegister->getData();
		$post = array(
		'name' => $function->_clean_input($register->getName()),
		'username' => $function->_clean_input($register->getUsername()),
		'password' => $function->_clean_input($register->getPass()),
		'confirmpass' => $function->_clean_input($register->getConfirmPass()),
		'mail' => $function->_clean_input($register->getMail()),
		'confirmmail' => $function->_clean_input($register->getConfirmMail()),
		'pincode' => $function->_clean_input($register->getPinCode()),
		'country' => $function->_clean_input($register->getCountry()),
		'address' => $function->_clean_input($register->getAddress())
		);
		if(empty($post['name'] or $post['username'] or $post['password'] or $post['confirmpass'] or $post['mail'] or $post['confirmmail'] or $post['pincode'] or $post['country'] or $post['address']))
		{
			$this->addFlash('message', 'Registration failed. All fields are required and cannon be blank!');
			return $this->redirectToRoute('login');
		}
		if($post['password'] !== $post['confirmpass'])
		{
			$this->addFlash('message', 'Registracion failed. The passwords doesnt match');
			return $this->redirectToRoute('login');
		}
		if($post['mail'] !== $post['confirmmail'])
		{
			$this->addFlash('message', 'Registration declined. The email addresses doesnt match');
			return $this->redirectToRoute('login');
		}
		if(!is_numeric($post['pincode']))
		{
			$this->addFlash('message', 'Registration failed. The PIN Code should contain only numbers and not letters!');
			return $this->redirectToRoute('login');
		}
		if($repository->UsernameTaken($post['username']))
		{
			$this->addFlash('message', 'Registration declined. The Account with '.$post['username'].' already exists in our base.');
			return $this->redirectToRoute('login');
		}
		if($repository->EmailTaken($post['mail']))
		{
			$this->addFlash('message', 'Registration declined. The account with '.$post['mail']. ' already exists. Click <a href="/forgotpw">Here</a> to reset your password');
			return $this->redirectToRoute('login');
		}
		$repository->createAccount($post['name'], $post['username'], $post['password'], $post['mail'], $post['pincode'], $post['country'], $post['address']);
		$this->addFlash('message', 'Successfully registered '. $post['name'].' Now you can log in.');
		return $this->redirectToRoute('login');
	}
	$this->addFlash('message', 'This method is only accepted via POST method.');
	return $this->redirectToRoute('login');
		
	}
	
	public function lost(Request $request, FunctionsRepository $function, LostpasswordRepository $repository)
	{
		$forgotpass = new Lostpassword();
		$page['website_name'] = 'Game CP';
		
		$formReset = $this->createForm(LostPasswordType::class, $forgotpass, array('csrf_protection' => false));
		$formReset->handleRequest($request);
		if($formReset->isSubmitted() && $formReset->isValid())
		{
			$forgotpass = $formReset->getData();
			$post = array(
			'email' => $function->_input_clean($forgotpass->getEmail()));
			if(empty($post['email']))
			{
				$this->addFlash('message', 'Error: The email address is required!');
				return $this->redirectToRoute('login');
			}
			$repository->resetPassword($post['email']);
			$this->addFlash('message', 'Your password has been reseted, check your mail for the new password.');
			return $this->redirectToRoute('login');
		}
		return $this->render('global/resetpassword.html.twig', array('form' => $formReset->createView(), 'websiteName' => $page['website_name']));
	}
			
	
	
}
		