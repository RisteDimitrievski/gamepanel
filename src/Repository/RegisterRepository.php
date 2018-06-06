<?php

namespace App\Repository;

use App\Entity\Register;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;

/**
 * @method Register|null find($id, $lockMode = null, $lockVersion = null)
 * @method Register|null findOneBy(array $criteria, array $orderBy = null)
 * @method Register[]    findAll()
 * @method Register[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegisterRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Register::class);
    }
	public function UsernameTaken($username)
	{
		$conn = $this->getEntityManager()->getConnection();
		$query = $conn->prepare('SELECT * FROM `clients` WHERE `username` = :username');
		$query->bindParam(':username', $username);
		$query->execute();
		$data = $query->fetch();
		if($data < 1)
		{
			return false;
		}
		return TRUE;
	}
	
	public function EmailTaken($email)
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
		return TRUE;
	}
	
	public function createAccount($name, $username, $password, $email, $pincode, $country, $address)
	{
		$conn = $this->getEntityManager()->getConnection();
		$query = $conn->prepare('INSERT INTO `clients` (`full name`, `username`, `password`, `email`, `pin`, `country`, `address`, `date`, `ip`) VALUES ( :name, :username, :password, :email, :pincode, :country, :address, :date, :ip)');
		$date = date('d.m.Y');
		$ip = $_SERVER['REMOTE_ADDR'];
		$pass = password_hash($password, PASSWORD_BCRYPT);
		$query->bindParam(':name', $name);
		$query->bindParam(':username', $username);
		$query->bindParam(':password', $pass);
		$query->bindParam(':email', $email);
		$query->bindParam(':pincode', $pincode);
		$query->bindParam(':country', $country);
		$query->bindParam(':address', $address);
		$query->bindParam(':date', $date);
		$query->bindParam(':ip', $ip);
        return $query->execute();
        
	}		
		
		
}
