<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LostPasswordRepository")
 */
class Lostpassword
{
	/**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
	 
    private $id;
    public $email;
    public function getId()
    {
        return $this->id;
    }
	
  
	 public $emails;
	public function getEmail()
	{
		return $this->email;
	}
	public function setEmail($email)
	{
		$this->email = $mail;
		return $this;
	}
	
	
}
