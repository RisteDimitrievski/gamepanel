<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RegisterRepository")
 */
class Register
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
	/*
    private $id;

    public function getId()
    {
        return $this->id;
    }
	*/
	public $name;
	public $username;
	public $pass;
	public $confirmpass;
	public $mail;
	public $confirmmail;
	public $pincode;
	public $country;
	public $address;
	
	
	public function getName(): ?string
	{
		return $this->name;
	}
	public function setName(string $name): self
	{
		$this->name = $name;
		return $this;
	}
	public function getUsername(): ?string
	{
		return $this->username;
	}
	public function setUsername(string $username):self
	{
		$this->username = $username;
		return $this;
	}
	public function getPass(): ?string
	{
		return $this->pass;
	}
	public function setPass(string $pass): self
	{
		$this->pass = $pass;
		return $this;
	}
	public function getConfirmPass(): ?string
	{
		return $this->confirmpass;
	}
	public function setConfirmPass(string $confirmpass):self
	{
		$this->confirmpass = $confirmpass;
        return $this;
	}
    public function getMail(): ?string
	{   
     return $this->mail;
	}
    public function setMail(string $mail):self
	{
    $this->mail = $mail;
    return $this;
	}
    public function getConfirmMail(): ?string 
	{
     return $this->confirmmail;
	}
    public function setConfirmMail(string $confirmmail):self
	{
     $this->confirmmail = $confirmmail;
     return $this;
	}
    public function getPinCode(): ?string
	{
    return $this->pincode;
	}
    public function setPinCode(string $pincode):self
	{
     $this->pincode = $pincode;
     return $this;
	}
    public function getCountry(): ?string 
	{
    return $this->country;
    }
    public function setCountry(string $country):self
	{
    $this->country = $country;
    return $this;
	}
    public function getAddress(): ?string
	{
     return $this->address;
	}
    public function setAddress(string $address):self
	{
    $this->address = $address;
    return $this;
	}	
}
