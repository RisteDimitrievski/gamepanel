<?php

namespace App\Repository;

use App\Entity\Lostpassword;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use App\Entity\FunctionsRepository;

/**
 * @method LostPassword|null find($id, $lockMode = null, $lockVersion = null)
 * @method LostPassword|null findOneBy(array $criteria, array $orderBy = null)
 * @method LostPassword[]    findAll()
 * @method LostPassword[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LostpasswordRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LostPassword::class);
    }
    public function resetPassword($email)
	{
		$conn = $this->getEntityManager()->getConnection();
		$query = $conn->prepare('SELECT * FROM `clients` WHERE `email` = :email');
		$query->bindParam(':email', $email);
		$query->execute();
		$data = $query->fetch();
		if($data < 1)
		{
			return FALSE;
		}
		$username = $data['username'];
		
		
		
		
		$name = $data['full name'];
		$query = $conn->prepare('SELECT * FROM `client_settings` WHERE `username` = :username');
		$query->bindParam(':username', $username);
		$query->execute();
		$data = $query->fetch();
		if($data['demo'] == 1)
		{
			return FALSE;
		}
		$function = new FunctionsRepository();
		$password = $function->randomString();
		$pass = password_hash($password, PASSWORD_BCRYPT);
		$query = $conn->prepare('UPDATE `clients` SET `password` = :password WHERE `email` = :email');
		$query->bindParam(':password', $pass);
		$query->bindParam(':email', $email);
		$query->execute();
		$ip = $_SERVER['REMOTE_ADDR'];
		$message = "
		Hello $name,
		You recently asked for reseting your account's password and the details are bellow.
		Your new password is: $password.
		---
		Requester IP address: $ip";
		mail($email, 'New account password', $message, 'FROM:admin@localhost');
		return TRUE;
	}
		
		

}
