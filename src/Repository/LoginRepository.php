<?php

namespace App\Repository;

use App\Entity\Login;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Repository\FunctionsRepository;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method Login|null find($id, $lockMode = null, $lockVersion = null)
 * @method Login|null findOneBy(array $criteria, array $orderBy = null)
 * @method Login[]    findAll()
 * @method Login[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoginRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Login::class);
    }

//    /**
//     * @return Login[] Returns an array of Login objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Login
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
	public function loggedIn($sesija)
	{
		$conn = $this->getEntityManager()->getConnection();
		$req = new Request();
		
		$cookie = $req->cookies;
		$username = $cookie->get('username');
		$user = htmlspecialchars(htmlentities(trim($username)));
	    
		$query = $conn->prepare('SELECT * FROM `clients` WHERE `username` = :username AND `session_id` = :session');
		$query->bindParam(':username', $user);
		$query->bindParam(':session', $sesija);
		$query->execute();
		$data = $query->fetch();
		if($data < 1)
		{
			return FALSE;
		}
		return TRUE;
	}
		
		
		
	public function queryLogin($email, $password)
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
		$hash = $data['password'];
		if(password_verify($password, $hash))
		{
			$date = date('d.M.Y');
			$request = new Response();
			$cookie = new Cookie('username', $data['username'], time()+1200, '/');
			$cookie_date = new Cookie('date', $date, time()+1200, '/');
			$request->headers->setCookie($cookie);
			$request->headers->setCookie($cookie_date);
			$request->send();
			$repository = new FunctionsRepository();
			$session = new Session();
			$session->set('cmssessionid', $repository->randomString());
			
			$query = $conn->prepare('UPDATE `clients` SET `session_id` = :session WHERE `username` = :username');
			$sesija = $session->get('cmssessionid');
			$query->bindParam(':session', $sesija);
			$query->bindParam(':username', $data['username']);
			$query->execute();
			return TRUE;
		}
		return false;
	}
}
