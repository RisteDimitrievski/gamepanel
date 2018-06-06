<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LoginRepository")
 */
class Login
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
	 
    private $id;

    public function getId()
    {
        return $this->id;
    }
	
	public $email;
	public $password;
	
	public function getEmail(): ?string
	{
		return $this->email;
	}
	public function setEmail(string $email):self
	{
		$this->email = $email;
		return $this;
	}
	public function getPassword(): ?string
	{
		return $this->password;
	}
	public function setPassword(string $password):self
	{
		$this->password = $password;
		return $this;
	}
}
